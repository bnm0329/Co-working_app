<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_lifetime', 0);
    session_start();
}
date_default_timezone_set('Africa/Tunis');

// List of pages allowed even if license is missing or invalid
$allowedWithoutLicense = [
    'admin/login_admin/login.php'
];

// Detect current script path
$currentPath = str_replace('\\', '/', $_SERVER['PHP_SELF']); // Normalize slashes
$licenseBypass = false;

foreach ($allowedWithoutLicense as $allowedPath) {
    if (substr($currentPath, -strlen($allowedPath)) === $allowedPath) {
        $licenseBypass = true;
        break;
    }
}

// License check only if not bypassed
if (!$licenseBypass) {
    $license_file = __DIR__ . '/license.json';

    if (!file_exists($license_file)) {
        die("🚫 Fichier de licence manquant.");
    }

    $license_data = json_decode(file_get_contents($license_file), true);

    if (!isset($license_data['license_key']) || trim($license_data['license_key']) === '') {
        die("🚫 Clé de licence manquante.");
    }

    $your_license_key = $license_data['license_key'];

    // ✅ External license validation (Keygen API)
    require_once __DIR__ . '/check_license.php';
    check_keygen_license($your_license_key);
}

// ✅ Telegram Bot Credentials
$telegramBotToken = "";
$telegramChatId   = "";

// ✅ MySQL Database Connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "bd1s";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Échec de connexion à la base de données: " . $conn->connect_error);
}

$smtp_host = "";           // Your SMTP server (e.g. smtp.gmail.com)
$smtp_port = 587;                          // Port (587 for TLS, 465 for SSL)
$smtp_username = "";         // SMTP login
$smtp_password = "";           // SMTP password or app password
$smtp_from_email = "";       // Sender email
$smtp_from_name = ""; 
?>
