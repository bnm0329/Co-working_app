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

$seats = [];
$query = "SELECT s.*, 
         (SELECT CONCAT(u.first_name, ' ', u.last_name)
          FROM sessions sess
          JOIN users u ON sess.user_id = u.user_id
          WHERE sess.seat_id = s.seat_id AND sess.end_time IS NULL LIMIT 1) AS occupant,
         (SELECT u.subscription_type
          FROM sessions sess
          JOIN users u ON sess.user_id = u.user_id
          WHERE sess.seat_id = s.seat_id AND sess.end_time IS NULL LIMIT 1) AS subscribe_type
FROM seats s";
$result = $conn->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $seats[] = $row;
    }
}
