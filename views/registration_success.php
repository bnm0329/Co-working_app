<!DOCTYPE html>
<html>
<head>
    <title>Inscription réussie !</title>
    <link rel="stylesheet" href="./views/assets/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.85">
</head>
<body>
<div class="logo-container">
    <img class="logo" src="./views/assets/images/logos.png?v=2" alt="Logo">
</div>
<div class="container">
    <h1>Inscription réussie !</h1>
    <p>Nom d'utilisateur : <strong style="color:red; font-size:18px;"><?= htmlspecialchars($username) ?></strong></p>
    <form action="seat_selection" method="get">
        <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
        <input class="continue-button" type="submit" value="Continuer vers la sélection des sièges">
    </form>
</div>
</body>
</html>
