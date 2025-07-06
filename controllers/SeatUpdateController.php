<?php
include('../config/config.php');
include('../config/functions.php');

if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seat_id = intval($_POST['seat_id']);
    $status = sanitizeInput($_POST['status']);

    if ($status === 'available') {
        $stmt = $conn->prepare("SELECT session_id, start_time FROM sessions WHERE seat_id = ? AND end_time IS NULL LIMIT 1");
        $stmt->bind_param("i", $seat_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $activeSession = $result->fetch_assoc();
            $session_id = $activeSession['session_id'];
            $start_time = strtotime($activeSession['start_time']);
            $end_time = date("Y-m-d H:i:s");
            $total_time = strtotime($end_time) - $start_time;

            $updateStmt = $conn->prepare("UPDATE sessions SET end_time = ?, total_time = ? WHERE session_id = ?");
            $updateStmt->bind_param("sii", $end_time, $total_time, $session_id);
            $updateStmt->execute();
        }
    }

    $statusUpdate = $conn->prepare("UPDATE seats SET status = ? WHERE seat_id = ?");
    $statusUpdate->bind_param("si", $status, $seat_id);
    if ($statusUpdate->execute()) {
        header("Location: manage_seats.php");
        exit;
    } else {
        echo "Error updating seat status.";
    }
}
