<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../views/assets/css/styles.css">
    
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="menu">
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_seats.php">Manage Seats</a>
            <a href="manage_sessions.php">Session Management</a>
            <a href="Subscribers.php">Subscribers Management</a> 
            <a href="message_notice.php">Manage Messages</a>
            <a href="service.php">Service Management</a>
            <a href="statistique.php">statistique</a>
            <a href="pricing.php">prices</a>

        </div>

        <h2>Overview</h2>
        <div class="stats">
            <p>Total Users: <span><?= $stats['users'] ?></span></p>
            <p>Available Seats: <span><?= $stats['availableSeats'] ?></span></p>
            <p>Occupied Seats: <span><?= $stats['occupiedSeats'] ?></span></p>
            <p>Active Sessions: <span><?= $stats['activeSessions'] ?></span></p>
            <p>Expired Subscriptions: <span class="expired"><?= $stats['expiredSubscriptions'] ?></span></p>
            <p>Subscriptions (Near Expiry): <span class="progress"><?= $stats['nearExpiry'] ?></span></p>
            <p>Waiting Services: <span><?= $stats['pendingServices'] ?></span></p>
        </div>
    </div>
</body>
</html>
