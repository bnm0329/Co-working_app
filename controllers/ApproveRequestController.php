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

if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);

    $stmt = $conn->prepare("SELECT service_id, quantity FROM service_requests WHERE request_id = ? AND status = 'pending'");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $request = $result->fetch_assoc();
        $service_id = $request['service_id'];
        $quantity = $request['quantity'];

        $updateQty = $conn->prepare("UPDATE services SET Quantity = Quantity - ? WHERE service_id = ? AND Quantity >= ?");
        $updateQty->bind_param("iii", $quantity, $service_id, $quantity);
        if ($updateQty->execute() && $updateQty->affected_rows > 0) {
            $approve = $conn->prepare("UPDATE service_requests SET status = 'approved' WHERE request_id = ?");
            $approve->bind_param("i", $request_id);
            if ($approve->execute()) {
                echo "Request approved and quantity updated.";
            } else {
                echo "Error approving request: " . $conn->error;
            }
        } else {
            echo "Not enough stock available.";
        }
    } else {
        echo "Request not found or already processed.";
    }
} else {
    echo "Invalid request.";
}
