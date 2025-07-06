<?php
include('../config/config.php');
include('../config/functions.php');
require_once '../models/SessionSummary.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_admin/login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$section = $_GET['section'] ?? 'active';
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';

$activeSessions = [];
$oldSessions = [];

if ($section === 'active') {
    $query = "
        SELECT s.session_id, s.seat_id, s.start_time,
               u.first_name, u.last_name, u.username,
               st.seat_number,
               GROUP_CONCAT(CONCAT(c.code, ' : ', cu.mac_address) SEPARATOR ' | ') AS coupon_mac_pairs,
               CONCAT(au.affiliate_coupon, ' (Owner: ', u2.first_name, ' ', u2.last_name, ')',
                      IF(a.discount_percentage IS NOT NULL AND a.discount_percentage != '',
                         CONCAT(' - Discount: ', a.discount_percentage, '/hr'), '')
               ) AS affiliate_code
        FROM sessions s
        JOIN users u ON s.user_id = u.user_id
        JOIN seats st ON s.seat_id = st.seat_id
        LEFT JOIN coupons c ON c.assigned_to_user_id = u.user_id
        LEFT JOIN captive_users cu ON cu.coupon = c.code
        LEFT JOIN affiliate_usage au ON au.user_id = u.user_id
        LEFT JOIN affiliate a ON au.affiliate_coupon = a.affiliate_coupon
        LEFT JOIN users u2 ON a.owner_user_id = u2.user_id
        WHERE s.end_time IS NULL";

    if ($search !== '') {
        $query .= " AND u.username LIKE '%$search%'";
    }

    $query .= " GROUP BY s.session_id ORDER BY s.start_time DESC";
    $activeSessionsResult = $conn->query($query);
    $activeSessions = $activeSessionsResult ? $activeSessionsResult->fetch_all(MYSQLI_ASSOC) : [];

    // Build list of seat_ids currently assigned to active sessions
    $activeSeatIds = [];
    foreach ($activeSessions as $session) {
        $activeSeatIds[] = intval($session['seat_id']);
    }

    // Protect against empty list in SQL IN clause
    $seatIdsList = count($activeSeatIds) ? implode(',', $activeSeatIds) : '0';

    // Query seats: available OR currently assigned to active sessions
    $seatsQuery = "
        SELECT seat_id, seat_number, status
        FROM seats
        WHERE status = 'available' OR seat_id IN ($seatIdsList)
        ORDER BY seat_number ASC";

    $seatsResult = $conn->query($seatsQuery);
    $availableSeats = [];
    if ($seatsResult) {
        while ($row = $seatsResult->fetch_assoc()) {
            $availableSeats[] = $row;
        }
    }
}



// Step 1: Count total sessions with end_time not null
$countQuery = "SELECT COUNT(DISTINCT s.session_id) as total FROM sessions s WHERE s.end_time IS NOT NULL";
$countResult = $conn->query($countQuery);
if (!$countResult) {
    die("Count query failed: " . $conn->error);
}
$countRow = $countResult->fetch_assoc();
$totalRows = (int)$countRow['total'];
$totalPages = ceil($totalRows / $limit);

// Correct page number if too big
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;

// Step 2: Fetch paginated sessions with joins
$query = "
    SELECT 
        s.session_id, 
        s.start_time, 
        s.end_time, 
        s.total_time,
        st.seat_number, 
        u.first_name, 
        u.last_name, 
        u.username,
        (
            SELECT GROUP_CONCAT(CONCAT(uc.coupon_code, ' : ', uc.mac_address) SEPARATOR ' | ')
            FROM user_coupons uc
            WHERE uc.user_id = u.user_id
        ) AS coupon_mac_pairs,
        CONCAT(
            au.affiliate_coupon, 
            ' (Owner: ', u2.first_name, ' ', u2.last_name, ')',
            IF(a.discount_percentage IS NOT NULL AND a.discount_percentage != '',
               CONCAT(' - Discount: ', a.discount_percentage, '/hr'), '')
        ) AS affiliate_code
    FROM sessions s
    JOIN users u ON s.user_id = u.user_id
    JOIN seats st ON s.seat_id = st.seat_id
    LEFT JOIN affiliate_usage au ON au.user_id = u.user_id
    LEFT JOIN affiliate a ON au.affiliate_coupon = a.affiliate_coupon
    LEFT JOIN users u2 ON a.owner_user_id = u2.user_id
    WHERE s.end_time IS NOT NULL
    GROUP BY s.session_id
    ORDER BY s.start_time DESC
    LIMIT $limit OFFSET $offset
";

$oldSessionsResult = $conn->query($query);
if (!$oldSessionsResult) {
    die("Main query failed: " . $conn->error);
}
$oldSessions = $oldSessionsResult->fetch_all(MYSQLI_ASSOC);

// Step 3: Fetch services for each session
foreach ($oldSessions as &$session) {
    $services = [];
    $sid = intval($session['session_id']);
    $servicesResult = $conn->query("
        SELECT sr.quantity, sv.service_name
        FROM service_requests sr
        JOIN services sv ON sr.service_id = sv.service_id
        WHERE sr.session_id = $sid AND sr.status = 'approved'
    ");
    if ($servicesResult) {
        while ($s = $servicesResult->fetch_assoc()) {
            $services[] = $s;
        }
    }
    $session['services'] = $services;
}
unset($session);