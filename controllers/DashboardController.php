<?php
include('./config/config.php');

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_app/login.php");
    exit;
}

$message = $_GET['message'] ?? '';
