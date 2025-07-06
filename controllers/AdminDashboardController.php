<?php
include('../config/config.php');
include('../config/functions.php');

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_admin/login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}

$stats = [
    'users' => 0,
    'availableSeats' => 0,
    'occupiedSeats' => 0,
    'activeSessions' => 0,
    'expiredSubscriptions' => 0,
    'nearExpiry' => 0,
    'pendingServices' => 0,
];

$queries = [
    'users' => "SELECT COUNT(*) as total FROM users",
    'availableSeats' => "SELECT COUNT(*) as total FROM seats WHERE status = 'available'",
    'occupiedSeats' => "SELECT COUNT(*) as total FROM seats WHERE status = 'occupied'",
    'activeSessions' => "SELECT COUNT(*) as total FROM sessions WHERE end_time IS NULL",
    'expiredSubscriptions' => "SELECT COUNT(*) as total FROM users WHERE subscription_end_date < NOW()",
    'nearExpiry' => "SELECT COUNT(*) as total FROM users WHERE subscription_end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 DAY)",
    'pendingServices' => "SELECT COUNT(*) as total FROM service_requests WHERE status='pending'",
];

foreach ($queries as $key => $query) {
    $result = $conn->query($query);
    $row = $result ? $result->fetch_assoc() : ['total' => 0];
    $stats[$key] = $row['total'];
}
