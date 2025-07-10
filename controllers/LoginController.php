<?php
include('./config/config.php');
include('./config/functions.php');
require_once __DIR__ . '/../models/UserModel.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_app/login");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = sanitizeInput($_POST['username']);
    $user = getUserByIdentifier($conn, $identifier);

    if ($user) {
        if ($user['subscription_type'] != 'none' && !empty($user['subscription_end_date'])) {
            if (strtotime($user['subscription_end_date']) < time()) {
                $view = 'views/login_expired';
                return;
            }
        }
        $username = $user['username'];
        header("Location: seat_selection?username=$username");
        exit;
    } else {
        $view = 'views/login_invalid';
        return;
    }
}
