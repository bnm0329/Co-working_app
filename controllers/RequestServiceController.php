<?php
include('../config/config.php');
include('../config/functions.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = intval($_POST['user_id']);
    $service_id = intval($_POST['service_id']);
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("SELECT session_id FROM sessions WHERE user_id = ? AND end_time IS NULL LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $sessionResult = $stmt->get_result();

    if ($sessionResult->num_rows === 0) {
        echo "<p style='color: red; font-weight: bold;'>Vous n'avez pas de session active. Veuillez démarrer une session avant de demander des services.</p>";
        exit;
    }

    $session_id = $sessionResult->fetch_assoc()['session_id'];

    $qtyStmt = $conn->prepare("SELECT Quantity FROM services WHERE service_id = ?");
    $qtyStmt->bind_param("i", $service_id);
    $qtyStmt->execute();
    $qtyResult = $qtyStmt->get_result();
    $service = $qtyResult->fetch_assoc();

    if ($service && $service['Quantity'] >= $quantity) {
        $insertStmt = $conn->prepare("INSERT INTO service_requests (session_id, service_id, quantity, status) VALUES (?, ?, ?, 'pending')");
        $insertStmt->bind_param("iii", $session_id, $service_id, $quantity);
        if ($insertStmt->execute()) {
            echo "<p style='color: green; font-weight: bold;'>Demande de service soumise avec succès.</p>";
        } else {
            echo "Erreur lors de la soumission : " . $conn->error;
        }
    } else {
        echo "La quantité demandée dépasse le stock disponible.";
    }
}
