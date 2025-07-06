<?php
include('../config/config.php');

$view = '../views/client_form.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = trim($_POST['username']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Erreur de base de données. Réessayez plus tard.";
        header("Location: index.php");
        exit();
    }

    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Utilisateur non trouvé. Veuillez vérifier votre nom d'utilisateur ou Email .";
        header("Location: index.php");
        exit();
    }

    $view = '../views/client_redirect.php';
}
