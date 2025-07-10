<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Subscription</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../views/assets/css/update_subscription_view.css">
</head>
<body>
    <div class="container">
        <h1>Mettre à jour l'abonnement</h1>
        <?php if($message != ""): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="update_subscription" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            
            <label for="full_name">Nom complet :</label>
            <input type="text" id="full_name" value="<?php echo $user['first_name'] . " " . $user['last_name']; ?>" readonly>
            
            <label for="coupon">Nom d'utilisateur :</label>
            <input type="text" id="coupon" value="<?php echo $user['username']; ?>" readonly>
            
            <label for="current_subscription">Abonnement actuel :</label>
            <input type="text" id="current_subscription" value="<?php echo ucfirst($user['subscription_type']); ?>" readonly>
            
            <label for="current_end_date">Date de fin d'abonnement actuelle :</label>
            <input type="text" id="current_end_date" value="<?php echo ($user['subscription_end_date'] && $user['subscription_end_date'] != '0000-00-00 00:00:00') ? $user['subscription_end_date'] : ""; ?>" readonly>
            
            <label for="subscription">Nouvel abonnement :</label>
            <select name="subscription" id="subscription" required>
                <option value="">Sélectionnez une nouvelle période d'abonnement</option>
                <option value="1_week">1 Semaine</option>
                <option value="2_weeks">2 Semaines</option>
                <option value="1_month">1 Mois</option>
                <option value="none">Retirer l'abonnement</option>
            </select>
            
            <input type="submit" value="Mettre à jour l'abonnement">
        </form>
        <a class="back-btn" href="subscribers">Retour aux abonnés</a>
    </div>
</body>
</html>
