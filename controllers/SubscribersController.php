<?php
include('../config/config.php');
include('../config/functions.php');

if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}

$message = '';
$newUsername = '';
$subscribers = [];
$noSubUsers = [];

// Fetch subscribed users
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// 1. Get total count of subscribers (with subscription_type != 'none')
$countSql = "SELECT COUNT(*) as total FROM users WHERE subscription_type != 'none'";
$countResult = $conn->query($countSql);
$totalRows = 0;
if ($countResult) {
    $countRow = $countResult->fetch_assoc();
    $totalRows = (int)$countRow['total'];
}
$totalPages = ceil($totalRows / $limit);

// 2. Fetch paginated subscribers data
$subscribers = [];
$subSql = "SELECT * FROM users WHERE subscription_type != 'none' LIMIT $limit OFFSET $offset";
$subResult = $conn->query($subSql);

if ($subResult) {
    while ($row = $subResult->fetch_assoc()) {
        $subscribers[] = $row;
    }
}

// Fetch unsubscribed users
$noSubResult = $conn->query("SELECT * FROM users WHERE subscription_type = 'none'");
if ($noSubResult) {
    while ($row = $noSubResult->fetch_assoc()) {
        $noSubUsers[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['user_id'])) {
        // Updating existing subscription
        $user_id = intval($_POST['user_id']);
        $subscription = sanitizeInput($_POST['subscription']);
        $subscription_end_date = null;

        if ($subscription === "1_week") {
            $subscription_end_date = date("Y-m-d H:i:s", strtotime("+1 week"));
        } elseif ($subscription === "2_weeks") {
            $subscription_end_date = date("Y-m-d H:i:s", strtotime("+2 weeks"));
        } elseif ($subscription === "1_month") {
            $subscription_end_date = date("Y-m-d H:i:s", strtotime("+1 month"));
        } else {
            $subscription = 'none';
        }

        $stmt = $conn->prepare("UPDATE users SET subscription_type = ?, subscription_end_date = ?, subscription_start_date = NOW() WHERE user_id = ?");
        $stmt->bind_param("ssi", $subscription, $subscription_end_date, $user_id);

        if ($stmt->execute()) {
            $message = "Subscription updated successfully.";
        } else {
            $message = "Error updating subscription: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $first_name   = sanitizeInput($_POST['first_name']);
        $last_name    = sanitizeInput($_POST['last_name']);
        $phone_number = sanitizeInput($_POST['phone_number']);
        $email        = sanitizeInput($_POST['email']);
        $user_type    = sanitizeInput($_POST['user_type']);
        $subscription = sanitizeInput($_POST['subscription']);

        $username = generateCoupon($conn, $first_name, $last_name, $user_type);
        $newUsername = $username;

        if ($subscription === "1_week") {
            $subscription_end_date = date("Y-m-d H:i:s", strtotime("+1 week"));
        } elseif ($subscription === "2_weeks") {
            $subscription_end_date = date("Y-m-d H:i:s", strtotime("+2 weeks"));
        } elseif ($subscription === "1_month") {
            $subscription_end_date = date("Y-m-d H:i:s", strtotime("+1 month"));
        } else {
            $subscription = 'none';
            $subscription_end_date = null;
        }

       $subscription_start_date = date("Y-m-d H:i:s");

$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone_number, email, username, subscription_type, subscription_start_date, subscription_end_date, user_type)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $first_name, $last_name, $phone_number, $email, $username, $subscription, $subscription_start_date, $subscription_end_date, $user_type);

        if ($stmt->execute()) {
            $message = "User created successfully.";
        } else {
            $message = "Error creating user: " . $stmt->error;
        }
        $stmt->close();
    }

    header("Location: subscribers.php");
    exit;
}
