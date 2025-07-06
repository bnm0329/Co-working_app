<?php
include('../config/config.php');
include('../config/functions.php');

if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}
$successMessage = '';
$errorMessage = '';
$messageData = null;

// Handle POST: insert or update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $active = isset($_POST['active']) ? 1 : 0;

    if (!empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE message SET message = ?, active = ? WHERE id = ?");
        $stmt->bind_param("sii", $message, $active, $id);
        $success = $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO message (message, active) VALUES (?, ?)");
        $stmt->bind_param("si", $message, $active);
        $success = $stmt->execute();
    }

    if ($success) {
        header("Location: message_notice.php");
        exit;
    } else {
        $errorMessage = "Error saving message: " . $stmt->error;
    }
}

// Handle GET actions
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM message WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: message_notice.php");
        exit;
    } else {
        $errorMessage = "Error deleting: " . $stmt->error;
    }
}

if (isset($_GET['activate'])) {
    $id = intval($_GET['activate']);
    $conn->query("UPDATE message SET active = 0");
    $stmt = $conn->prepare("UPDATE message SET active = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: message_notice.php");
        exit;
    } else {
        $errorMessage = "Error activating: " . $stmt->error;
    }
}

if (isset($_GET['deactivate_all'])) {
    if ($conn->query("UPDATE message SET active = 0")) {
        header("Location: message_notice.php");
        exit;
    } else {
        $errorMessage = "Error deactivating all.";
    }
}

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM message WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $messageData = $result->fetch_assoc();
}

$messagesResult = $conn->query("SELECT * FROM message");
