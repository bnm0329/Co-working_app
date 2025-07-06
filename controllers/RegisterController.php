<?php
include('./config/config.php');
include('./config/functions.php');
require_once __DIR__ . '/../models/UserModel.php';
if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_app/login.php");
    exit;
}


$view = 'views/register_form.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name   = sanitizeInput($_POST['first_name']);
    $last_name    = sanitizeInput($_POST['last_name']);
    $phone_number = sanitizeInput($_POST['phone_number']);
    $email        = sanitizeInput($_POST['email']);
    $user_type    = sanitizeInput($_POST['user_type']);

    $existing = emailExists($conn, $email);

    if ($existing) {
        $existing_username = $existing['username'];
        $existing_email = $existing['email'];
        $view = 'views/registration_exists.php';
    } else {
        $username = generateCoupon($conn, $first_name, $last_name, $user_type);
        if (registerUser($conn, $first_name, $last_name, $phone_number, $email, $username, $user_type)) {
            $view = 'views/registration_success.php';
        } else {
            echo "Erreur lors de l'inscription.";
            exit;
        }
    }
}
