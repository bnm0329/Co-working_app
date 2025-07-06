<?php
function fetchAllSeats($conn) {
    $query = "SELECT * FROM seats ORDER BY seat_number ASC";
    $result = $conn->query($query);
    $seats = [];
    while ($row = $result->fetch_assoc()) {
        $seats[$row['seat_number']] = $row;
    }
    return $seats;
}
function isSeatAvailable($conn, $seat_id) {
    $stmt = $conn->prepare("SELECT * FROM seats WHERE seat_id = ? AND status = 'available'");
    $stmt->bind_param("i", $seat_id);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function markSeatAsOccupied($conn, $seat_id) {
    $stmt = $conn->prepare("UPDATE seats SET status = 'occupied' WHERE seat_id = ?");
    $stmt->bind_param("i", $seat_id);
    $stmt->execute();
}

function startUserSession($conn, $user_id, $seat_id) {
    $stmt = $conn->prepare("INSERT INTO sessions (user_id, seat_id, start_time) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $user_id, $seat_id);
    $stmt->execute();
}
