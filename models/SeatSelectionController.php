<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'models/SeatModel.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: login_admin.php");
    exit;
}

$username = isset($_GET['username']) ? sanitizeInput($_GET['username']) : '';
if (empty($username)) {
    echo "Username code missing. <a href='index.php'>Go back</a>";
    exit;
}

$seats = fetchAllSeats($conn);
$conn->close();
