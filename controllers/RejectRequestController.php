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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);

    $stmt = $conn->prepare("UPDATE service_requests SET status = 'rejected' WHERE request_id = ?");
    $stmt->bind_param("i", $request_id);

    if ($stmt->execute()) {
        echo "Request rejected successfully.";
    } else {
        echo "Error rejecting request: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
