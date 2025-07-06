<?php
include('../config/config.php');
include('../config/functions.php');;
require_once '../models/SessionSummary.php';

$session_id = isset($_GET['session_id']) ? intval($_GET['session_id']) : 0;
if ($session_id <= 0) {
    die("Invalid session ID.");
}

if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit;
}

// Fetch session & user info
$stmt = $conn->prepare("
    SELECT s.session_id, s.start_time, s.end_time, s.total_time, 
           s.user_id, u.first_name, u.last_name, u.username, u.phone_number,
           st.seat_number
    FROM sessions s
    JOIN users u ON s.user_id = u.user_id
    JOIN seats st ON s.seat_id = st.seat_id
    WHERE s.session_id = ?
");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $session = $result->fetch_assoc();
} else {
    die("Session not found.");
}

$sessionStart = $session['start_time'];
$user_id = $session['user_id'];

// Coupons & MACs
$couponQuery = "
    SELECT c.code AS coupon_code, cu.mac_address 
    FROM coupons c 
    LEFT JOIN captive_users cu ON c.code = cu.coupon 
    WHERE c.assigned_to_user_id = ? 
      AND ABS(TIMESTAMPDIFF(SECOND, ?, c.assigned_time)) < 300";
$couponStmt = $conn->prepare($couponQuery);
$couponStmt->bind_param("is", $user_id, $sessionStart);
$couponStmt->execute();
$couponResult = $couponStmt->get_result();
$coupons = $couponResult ? $couponResult->fetch_all(MYSQLI_ASSOC) : [];

// Affiliate usage
$affQuery = "
    SELECT au.affiliate_coupon, u2.first_name, u2.last_name, a.discount_percentage
    FROM affiliate_usage au
    JOIN affiliate a ON au.affiliate_coupon = a.affiliate_coupon
    JOIN users u2 ON a.owner_user_id = u2.user_id
    WHERE au.user_id = ? AND ABS(TIMESTAMPDIFF(SECOND, ?, au.used_at)) < 300
    LIMIT 1";
$affStmt = $conn->prepare($affQuery);
$affStmt->bind_param("is", $user_id, $sessionStart);
$affStmt->execute();
$affResult = $affStmt->get_result();
$affData = $affResult && $affResult->num_rows > 0 ? $affResult->fetch_assoc() : null;

// Services
$servicesProvided = [];
$serviceQuery = "
    SELECT sr.quantity, sr.requested_at, sv.service_name, sv.service_price 
    FROM service_requests sr 
    JOIN services sv ON sr.service_id = sv.service_id 
    WHERE sr.session_id = ? AND sr.status = 'approved'";
$serviceStmt = $conn->prepare($serviceQuery);
$serviceStmt->bind_param("i", $session_id);
$serviceStmt->execute();
$serviceResult = $serviceStmt->get_result();
if ($serviceResult) {
    while ($row = $serviceResult->fetch_assoc()) {
        $servicesProvided[] = $row;
    }
}
$durationMinutes = round($session['total_time'] / 60);

$pricingStmt = $conn->prepare("
    SELECT price FROM pricing
    WHERE type = 'hourly' AND duration_minutes <= ?
    ORDER BY duration_minutes DESC
    LIMIT 1");
$pricingStmt->bind_param("i", $durationMinutes);
$pricingStmt->execute();
$pricingResult = $pricingStmt->get_result();
$pricingRow = $pricingResult && $pricingResult->num_rows > 0 ? $pricingResult->fetch_assoc() : null;
$session_price = $pricingRow ? $pricingRow['price'] : 0.00;

