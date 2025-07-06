<?php
include('../config/config.php');
include('../config/functions.php');
require_once '../models/SessionSummary.php';



if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}

$username = isset($_GET['username']) ? trim($_GET['username']) : '';
if ($username === '') {
    die("Username is required.");
}

// Get user info
$userStmt = $conn->prepare("SELECT user_id, first_name, last_name, username FROM users WHERE username = ?");
$userStmt->bind_param("s", $username); // Fixed type and variable
$userStmt->execute();
$userResult = $userStmt->get_result();
if ($userResult->num_rows === 0) {
    die("User not found.");
}
$user = $userResult->fetch_assoc();
$user_id = $user['user_id']; // Now available for use below

// Get sessions
$sessions = [];
$sessionQuery = "
    SELECT s.session_id, s.start_time, s.end_time, s.total_time, st.seat_number
    FROM sessions s
    LEFT JOIN seats st ON s.seat_id = st.seat_id
    WHERE s.user_id = ?
    ORDER BY s.start_time DESC";
$sessionStmt = $conn->prepare($sessionQuery);
$sessionStmt->bind_param("i", $user_id);
$sessionStmt->execute();
$sessionResults = $sessionStmt->get_result();

while ($session = $sessionResults->fetch_assoc()) {
    // Get coupon
    $couponQuery = "
        SELECT c.code AS coupon_code, cu.mac_address
        FROM coupons c
        LEFT JOIN captive_users cu ON c.code = cu.coupon
        WHERE c.assigned_to_user_id = ?
        AND ABS(TIMESTAMPDIFF(SECOND, ?, c.assigned_time)) < 300
        LIMIT 1";
    $couponStmt = $conn->prepare($couponQuery);
    $start = $session['start_time'];
    $couponStmt->bind_param("is", $user_id, $start);
    $couponStmt->execute();
    $couponResult = $couponStmt->get_result();
    $coupon = $couponResult->fetch_assoc() ?? ['coupon_code' => 'No Coupon', 'mac_address' => 'N/A'];

    // Get services
    $servicesQuery = "
        SELECT sr.quantity, sr.requested_at, sv.service_name, sv.service_price
        FROM service_requests sr
        JOIN services sv ON sr.service_id = sv.service_id
        WHERE sr.session_id = ? AND sr.status = 'approved'";
    $servicesStmt = $conn->prepare($servicesQuery);
    $servicesStmt->bind_param("i", $session['session_id']);
    $servicesStmt->execute();
    $servicesResult = $servicesStmt->get_result();
    $services = $servicesResult->fetch_all(MYSQLI_ASSOC);

    $session['coupon_code'] = $coupon['coupon_code'];
    $session['mac_address'] = $coupon['mac_address'];
    $session['services'] = $services;
    $sessions[] = $session;
}
