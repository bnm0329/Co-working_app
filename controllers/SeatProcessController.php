<?php
include('./config/config.php');
include('./config/functions.php');
require_once 'models/SeatModel.php';
require_once 'models/UserModel.php';
require_once 'views/partials/display_message.php';

// PHPMailer manual includes
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';
require './PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_app/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $seat_id = intval($_POST['seat_id']);
    $_SESSION['username'] = $username;

    $user = getUserByUsername($conn, $username);
    if (!$user) {
        displayMessage("Utilisateur Invalide", "Utilisateur non trouvé. <a href='index.php'>Accueil</a>");
    }

    $user_id = $user['user_id'];

    if (hasActiveSession($conn, $user_id)) {
        displayMessage("Session Active", "Vous avez déjà une session active ! <a href='index.php'>Accueil</a>");
    }

    if (!isSeatAvailable($conn, $seat_id)) {
        displayMessage("Siège Occupé", "Siège non disponible. <a href='seat_selection.php?username=" . urlencode($username) . "'>Choisir un autre</a>");
    }

    markSeatAsOccupied($conn, $seat_id);
    startUserSession($conn, $user_id, $seat_id);

    // ✅ Prepare and send the email
    $startTime = date('d/m/Y H:i');
    $year = date('Y');

    $emailTemplate = file_get_contents('views/emails/welcome_email.html');
    $emailBody = str_replace(
        ['{username}', '{email}', '{start_time}', '{year}'],
        [$username, $user['email'], $startTime, $year],
        $emailTemplate
    );

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $smtp_port;

        $mail->setFrom($smtp_from_email, $smtp_from_name);
        $mail->addAddress($user['email'], $username);

        $mail->isHTML(true);
        $mail->Subject = "Bienvenue chez CoVilla, $username";
        $mail->Body    = $emailBody;

        $mail->send();
    } catch (Exception $e) {
        error_log("Erreur lors de l'envoi du mail: " . $mail->ErrorInfo);
    }

    $wifiHTML = "
    <div class='welcome-message'>
        <h3>Bienvenue chez CoVilla</h3>
        <div class='wifi-details'>
            <p>📶 Paramètres Wi-Fi :</p>
            <ul>
                <li><strong>Réseau:</strong> Covilla_5G | Covilla_3G | Covilla.tn</li>
                <li><strong>Mot de passe:</strong> Covilla.tn</li>
            </ul>
        </div>
        <center>
            <a href='index.php' class='confirm-btn'>
                ✅ Retour à la page d'accueil
            </a>
        </center>
    </div>";

    displayMessage("Session Activée", $wifiHTML);
}
