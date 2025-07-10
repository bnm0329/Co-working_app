<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résumé de la session</title>
    <link rel="stylesheet" href="../views/assets/css/admin_session_summary.css">
</head>
<body>
<div class="summary">
    <h2>Résumé de la session</h2>
    <table>
        <tr><th>Nom complet</th><td><?= htmlspecialchars($session['first_name'] . ' ' . $session['last_name']) ?></td></tr>
        <tr><th>Nom d'utilisateur</th><td><?= htmlspecialchars($session['username']) ?></td></tr>
        <tr><th>Téléphone</th><td><?= htmlspecialchars($session['phone_number']) ?></td></tr>
        <tr><th>Siège</th><td><?= htmlspecialchars($session['seat_number']) ?></td></tr>
        <tr><th>Heure de début</th><td><?= htmlspecialchars($session['start_time']) ?></td></tr>
        <tr><th>Heure de fin</th><td><?= htmlspecialchars($session['end_time']) ?></td></tr>
        <tr><th>Durée totale</th><td><?= $session['total_time'] ? format_duration($session['total_time']) : 'N/D' ?></td></tr>
        <tr><th>Prix de la session</th><td><?= number_format($session_price, 2) ?> TND</td></tr>
        <tr><th>Type d'abonnement</th><td><?= !empty($session['subscription_type']) ? htmlspecialchars($session['subscription_type']) : 'N/D' ?></td></tr>
    </table>

    <?php if (!empty($servicesProvided)): ?>
        <h2>Services fournis</h2>
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Prix (dinar)</th>
                    <th>Quantité</th>
                    <th>Date de la demande</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicesProvided as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['service_name']) ?></td>
                        <td><?= htmlspecialchars($s['service_price']) ?></td>
                        <td><?= htmlspecialchars($s['quantity']) ?></td>
                        <td><?= htmlspecialchars($s['requested_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun service n'a été fourni pendant cette session.</p>
    <?php endif; ?>

    <a class="home-btn" href="index">Retour au tableau de bord</a>
</div>
</body>
</html>
