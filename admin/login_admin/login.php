<?php
include_once(__DIR__ . '/../../config/config.php');
include_once(__DIR__ . '/../../config/functions.php');

$error = "";
$licenseMessage = "";

// Define encryption key
$secret_key = 'mySuperSecretKey2024'; // Make sure this matches config license check
$licenseFile = __DIR__ . '/../../config/license.json.enc';
$storedLicense = "";
$licenseExpiry = "";

// Load encrypted license info
if (file_exists($licenseFile)) {
    $encrypted = file_get_contents($licenseFile);
    $decrypted = openssl_decrypt(
        $encrypted,
        'AES-256-CBC',
        $secret_key,
        0,
        substr(hash('sha256', $secret_key), 0, 16)
    );

    $data = json_decode($decrypted, true);
    if (is_array($data)) {
        $storedLicense = $data['key'] ?? "";
        $licenseExpiry = $data['expires_at'] ?? "";
    }
}

// If license update is submitted
if (isset($_POST['update_license'])) {
    $newLicense = sanitizeInput($_POST['license_key']);
    if (!empty($newLicense)) {
        // Build new encrypted license content
        $newData = [
            'key' => $newLicense,
            'expires_at' => '', // Will be updated on next online check
            'hash' => hash_hmac('sha256', $newLicense, $secret_key),
        ];

        $plain = json_encode($newData, JSON_PRETTY_PRINT);
        $encrypted = openssl_encrypt(
            $plain,
            'AES-256-CBC',
            $secret_key,
            0,
            substr(hash('sha256', $secret_key), 0, 16)
        );

        if (file_put_contents($licenseFile, $encrypted) !== false) {
            $licenseMessage = "✅ Clé de licence mise à jour avec succès.";
            $storedLicense = $newLicense;
            $licenseExpiry = "";
        } else {
            $licenseMessage = "❌ Échec de la mise à jour du fichier de licence.";
        }
    } else {
        $licenseMessage = "❌ La clé de licence ne peut pas être vide.";
    }
}

// Admin login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password']) && !isset($_POST['update_license'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($password === $admin['password']) {
            if ($admin['role'] === 'admin') {
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['role'] = $admin['role'];
                header("Location: ../index.php");
                exit;
            } else {
                $error = "Accès refusé. Vous n'êtes pas autorisé à accéder à cette page.";
            }
        } else {
            $error = "Nom d'utilisateur ou mot de passe invalide.";
        }
    } else {
        $error = "Nom d'utilisateur ou mot de passe invalide.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../views/assets/css/main.css">
    <title>Connexion Admin</title>
    <style>
        .container {
            max-width: 420px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            display: block;
            max-width: 200px;
            margin: 0 auto;
        }
        h1 {
            color: #2c3e50;
        }
        .error {
            color: #f71010;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 30px;
            background: #3c48f4;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background: #2a37c2;
        }
        .update-note {
            font-size: 13px;
            color: #555;
            margin-top: -10px;
            margin-bottom: 5px;
            cursor: pointer;
            text-decoration: underline;
        }
        .expiry-info {
            font-size: 12px;
            color: #666;
            margin-bottom: 15px;
        }
    </style>
    <script>
        function enableLicenseEdit() {
            const input = document.getElementById('license_key');
            input.disabled = false;
            input.focus();
        }
    </script>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="../../views/assets/images/logos.png?v=2" alt="Logo">
</div>
<div class="container">
    <h1>Connexion Admin</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($licenseMessage): ?>
        <p class="<?= str_starts_with($licenseMessage, '✅') ? 'success' : 'error' ?>"><?= htmlspecialchars($licenseMessage) ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Se connecter">
    </form>

    <form method="post" action="">
        <label for="license_key">Clé de licence :</label>
        <input type="text" name="license_key" id="license_key" value="<?= htmlspecialchars($storedLicense) ?>" disabled>

        <?php if (!empty($licenseExpiry)): ?>
            <p class="expiry-info">📅 Expire le : <strong><?= htmlspecialchars($licenseExpiry) ?></strong></p>
        <?php endif; ?>

        <span class="update-note" onclick="enableLicenseEdit()">🛠️ Mettre à jour la clé de licence</span>
        <input type="submit" name="update_license" value="Enregistrer la licence">
    </form>
</div>
</body>
</html>
