<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des sessions – <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></title>
    <link rel="stylesheet" href="../views/assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../views/assets/css/admin_user_sessions.css">
    <script src="../views/assets/js/admin_user_sessions.js"></script>
</head>
<body>

<h1>Historique des sessions pour <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></h1>
<center><a href="manage_users" class="back-link">&larr; Retour aux utilisateurs</a></center>

<table>
    <thead>
        <tr>
            <th>Siège</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <th>Durée totale</th>
            <th>Code coupon</th>
            <th>Adresse MAC</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($sessions)): ?>
            <?php foreach ($sessions as $session): ?>
                <tr>
                    <td><?= htmlspecialchars($session['seat_number']) ?></td>
                    <td><?= htmlspecialchars($session['start_time']) ?></td>
                    <td><?= htmlspecialchars($session['end_time']) ?></td>
                    <td><?= $session['total_time'] ? format_duration($session['total_time']) : 'N/D' ?></td>
                    <td><?= htmlspecialchars($session['coupon_code']) ?></td>
                    <td><?= htmlspecialchars($session['mac_address']) ?></td>
                    <td><span class="toggle-btn" onclick="toggleDetails(<?= $session['session_id'] ?>)">Voir les détails</span></td>
                </tr>
                <tr id="details-<?= $session['session_id'] ?>" class="details">
                    <td colspan="8">
                        <strong>Services demandés :</strong>
                        <ul>
                            <?php if (!empty($session['services'])): ?>
                                <?php foreach ($session['services'] as $service): ?>
                                    <li>
                                        <?= intval($service['quantity']) ?>x 
                                        <?= htmlspecialchars($service['service_name']) ?> 
                                        (<?= htmlspecialchars($service['service_price']) ?> par unité) 
                                        – Demandé le : <?= htmlspecialchars($service['requested_at']) ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>Aucun service utilisé.</li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">Aucune session trouvée.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
