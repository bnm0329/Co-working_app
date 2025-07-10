<?php
include('../config/config.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_id = intval($_POST['session_id']);
    $new_seat_id = intval($_POST['seat_id']);

    // 1. Get the current seat_id of this session
    $stmt = mysqli_prepare($conn, "SELECT seat_id FROM sessions WHERE session_id = ?");
    if (!$stmt) {
        echo "Échec de la préparation : " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $session_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $old_seat_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($old_seat_id == $new_seat_id) {
        echo "Siège inchangé.";
        exit;
    }

    // 2. Check if new seat is already occupied by an active session (end_time IS NULL)
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM sessions WHERE seat_id = ? AND end_time IS NULL AND session_id != ?");
    if (!$stmt) {
        echo "Échec de la préparation : " . mysqli_error($conn);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "ii", $new_seat_id, $session_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        echo "Le nouveau siège est déjà occupé !";
        exit;
    }

    mysqli_begin_transaction($conn);

    try {
        $updateSession = mysqli_prepare($conn, "UPDATE sessions SET seat_id = ?, updated_at = NOW() WHERE session_id = ?");
        mysqli_stmt_bind_param($updateSession, "ii", $new_seat_id, $session_id);
        mysqli_stmt_execute($updateSession);
        mysqli_stmt_close($updateSession);

        // 5. Mark new seat as 'occupied'
        $markNew = mysqli_prepare($conn, "UPDATE seats SET status = 'occupied' WHERE seat_id = ?");
        mysqli_stmt_bind_param($markNew, "i", $new_seat_id);
        mysqli_stmt_execute($markNew);
        mysqli_stmt_close($markNew);

        // 6. Mark old seat as 'available'
        $markOld = mysqli_prepare($conn, "UPDATE seats SET status = 'available' WHERE seat_id = ?");
        mysqli_stmt_bind_param($markOld, "i", $old_seat_id);
        mysqli_stmt_execute($markOld);
        mysqli_stmt_close($markOld);

        // 7. Commit transaction
        mysqli_commit($conn);

        echo "Siège mis à jour avec succès.";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Échec de la mise à jour du siège : " . $e->getMessage();
    }
}
?>
