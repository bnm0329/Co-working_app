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

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// 1. Get total number of users
$countSql = "SELECT COUNT(*) as total FROM users";
$countResult = $conn->query($countSql);
$totalRows = 0;
if ($countResult) {
    $countRow = $countResult->fetch_assoc();
    $totalRows = (int)$countRow['total'];
}
$totalPages = ceil($totalRows / $limit);

// 2. Get paginated users
$users = [];
$query = "SELECT * FROM users LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
