<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord administrateur</title>
    <link rel="stylesheet" href="../views/assets/css/styles.css">
    
</head>
<body>
    <div class="container">
        <h1>Tableau de bord administrateur</h1>
        <div class="menu">
            <a href="manage_users">Gérer les utilisateurs</a>
            <a href="manage_seats">Gérer les sièges</a>
            <a href="manage_sessions">Gestion des sessions</a>
            <a href="subscribers">Gestion des abonnés</a> 
            <a href="message_notice">Gérer les messages</a>
            <a href="service">Gestion des services</a>
            <a href="statistique">Statistiques</a>
            <a href="pricing">Tarifs</a>
        </div>

        <h2>Vue d'ensemble</h2>
        <div class="stats">
            <p>Utilisateurs totaux : <span><?= $stats['users'] ?></span></p>
            <p>Sièges disponibles : <span><?= $stats['availableSeats'] ?></span></p>
            <p>Sièges occupés : <span><?= $stats['occupiedSeats'] ?></span></p>
            <p>Sessions actives : <span><?= $stats['activeSessions'] ?></span></p>
            <p>Abonnements expirés : <span class="expired"><?= $stats['expiredSubscriptions'] ?></span></p>
            <p>Abonnements (proche expiration) : <span class="progress"><?= $stats['nearExpiry'] ?></span></p>
            <p>Services en attente : <span><?= $stats['pendingServices'] ?></span></p>
        </div>
    </div>
</body>
</html>
