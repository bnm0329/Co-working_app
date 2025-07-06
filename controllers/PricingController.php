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

$message = '';
$pricing = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = sanitizeInput($_POST['type']);
    $label = sanitizeInput($_POST['label']);
    $price = floatval($_POST['price']);
    $duration = isset($_POST['duration_minutes']) && $_POST['duration_minutes'] !== '' 
                ? intval($_POST['duration_minutes']) : null;

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        // Update
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE pricing SET type = ?, label = ?, duration_minutes = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssidi", $type, $label, $duration, $price, $id);
        $message = $stmt->execute() ? "Pricing updated successfully." : "Error: " . $stmt->error;
    } else {
        // Create
        $stmt = $conn->prepare("INSERT INTO pricing (type, label, duration_minutes, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssid", $type, $label, $duration, $price);
        $message = $stmt->execute() ? "New pricing added successfully." : "Error: " . $stmt->error;
    }

    header("Location: pricing.php");
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM pricing WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: pricing.php");
    exit;
}

// Retrieve
$result = $conn->query("SELECT * FROM pricing ORDER BY type, duration_minutes ASC, price ASC");
if ($result) {
    $pricing = $result->fetch_all(MYSQLI_ASSOC);
}
