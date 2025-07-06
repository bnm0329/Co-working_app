<?php
include('../config/config.php');
include('../config/functions.php');

if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['session_id'], $_POST['seat_id'])) {
    $session_id = intval($_POST['session_id']);
    $seat_id = intval($_POST['seat_id']);

    $stmt = $conn->prepare("SELECT start_time FROM sessions WHERE session_id = ?");
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $session = $result->fetch_assoc();
        $start_time = strtotime($session['start_time']);
        $end_time = time();
        $total_time = $end_time - $start_time;
        $end_time_str = date("Y-m-d H:i:s", $end_time);

        $update = $conn->prepare("UPDATE sessions SET end_time = ?, total_time = ? WHERE session_id = ?");
        $update->bind_param("sii", $end_time_str, $total_time, $session_id);

        if ($update->execute()) {
            $seatReset = $conn->prepare("UPDATE seats SET status = 'available' WHERE seat_id = ?");
            $seatReset->bind_param("i", $seat_id);
            $seatReset->execute();

            header("Location: session_summary.php?session_id=" . $session_id);
            exit;
        } else {
            echo "Error updating session: " . $conn->error;
        }
    } else {
        echo "Session not found.";
    }
} else {
    echo "Invalid request.";
}
