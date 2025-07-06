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
$services = [];
$pendingRequests = [];
$section = $_GET['section'] ?? 'active';

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_service'])) {
        $service_name = sanitizeInput($_POST['service_name']);
        $service_price = floatval($_POST['service_price']);
        $Quantity = intval($_POST['Quantity']);
        $stmt = $conn->prepare("INSERT INTO services (service_name, service_price, Quantity, service_status) VALUES (?, ?, ?, 'enabled')");
        $stmt->bind_param("sdi", $service_name, $service_price, $Quantity);
        $message = $stmt->execute() ? "Service added successfully." : "Error: " . $stmt->error;
    }

    // Handle Update
    if (isset($_POST['update_service'])) {
        $id = intval($_POST['service_id']);
        $status = sanitizeInput($_POST['service_status']);
        $qty = intval($_POST['newQuantity']);
        $stmt = $conn->prepare("UPDATE services SET service_status = ?, Quantity = ? WHERE service_id = ?");
        $stmt->bind_param("sii", $status, $qty, $id);
        $message = $stmt->execute() ? "Service updated successfully." : "Error: " . $stmt->error;
    }

    // Handle Delete
    if (isset($_POST['delete_service'])) {
        $id = intval($_POST['service_id']);
        $stmt = $conn->prepare("DELETE FROM services WHERE service_id = ?");
        $stmt->bind_param("i", $id);
        $message = $stmt->execute() ? "Service deleted successfully." : "Error: " . $stmt->error;
    }

    header("Location: service.php");
    exit;
}

// Fetch services
$serviceQuery = "SELECT * FROM services ORDER BY created_at DESC";
$serviceResult = $conn->query($serviceQuery);
if ($serviceResult) {
    while ($row = $serviceResult->fetch_assoc()) {
        $services[] = $row;
    }
}

// Fetch pending service requests
$requestQuery = "
    SELECT sr.request_id, sr.quantity, sr.status, sr.requested_at,
           CONCAT(u.first_name, ' ', u.last_name) AS client_name,
           u.username, st.seat_number,
           sv.service_name, sv.service_price
    FROM service_requests sr
    JOIN sessions s ON sr.session_id = s.session_id
    JOIN users u ON s.user_id = u.user_id
    JOIN seats st ON s.seat_id = st.seat_id
    JOIN services sv ON sr.service_id = sv.service_id
    WHERE sr.status = 'pending'
    ORDER BY sr.requested_at DESC";
$requestResult = $conn->query($requestQuery);
if ($requestResult) {
    while ($row = $requestResult->fetch_assoc()) {
        $pendingRequests[] = $row;
    }
}
