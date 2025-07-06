<?php
include('../config/config.php');
include('../config/functions.php');

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    $query = "SELECT * FROM admin WHERE username = '$username' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($password === $admin['password']) {
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: ../index.php");
            exit;
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
    <title>Connexion interface</title>
    <link rel="stylesheet" href="../views/assets/css/main.css">
    <style>
        .container {
            max-width: 400px;
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
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
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
    </style>
</head>
<body>
<div class="logo-container">
            <img class="logo" src="../views/assets/images/logos.png?v=2" alt="Logo">
        </div>
    <div class="container">
        
        <h1>Connexion interface</h1>
        <?php if ($error != ""): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>
</html>
