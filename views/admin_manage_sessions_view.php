<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des sessions</title>
    <link rel="stylesheet" href="../views/assets/css/admin_main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../views/assets/css/admin_manage_sessions.css">
    <script src="../views/assets/js/admin_manage_sessions.js"></script>
</head>
<body>

    <h1>Historique des sessions</h1>
   <center><a href="index" class="back-link">&larr; Retour au tableau de bord</a></center>

    <div class="tabs">
        <a href="?section=active" class="<?= $section === 'active' ? 'active' : '' ?>">Sessions actives</a>
        <a href="?section=old" class="<?= $section === 'old' ? 'active' : '' ?>">Anciennes sessions</a>
    </div>


    <?php if ($section === 'active'): ?>
        <h2>Sessions actives</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom complet</th>
                    <th>Nom d'utilisateur</th>
                    <th>Siège</th>
                    <th>Heure de début</th>
                    <th>Abonnement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activeSessions as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
<td>
    <select id="seatSelect_<?= $row['session_id'] ?>">
        <?php foreach ($availableSeats as $seat): ?>
            <option value="<?= $seat['seat_id'] ?>" <?= $seat['seat_number'] == $row['seat_number'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($seat['seat_number']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button onclick="updateSeat(<?= $row['session_id'] ?>)">Enregistrer</button>
</td>
                        <td><?= htmlspecialchars($row['start_time']) ?></td>
                        <td><?= !empty($row['subscription_type']) ? htmlspecialchars($row['subscription_type']) : 'N/D' ?></td>
                        <td><button onclick="stopSession(<?= $row['session_id'] ?>, <?= $row['seat_id'] ?>)">Arrêter la session</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <h2>Anciennes sessions</h2>
        <button onclick="exportTableToCSV('old_sessions.csv')" class="export">Exporter en CSV</button>
        <table>
            <thead>
                <tr>
                    <th>Nom complet</th>
                    <th>Nom d'utilisateur</th>
                    <th>Siège</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                    <th>Durée totale</th>
                    <th>Type d'abonnement</th>
                    <th>Services fournis</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($oldSessions as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['seat_number']) ?></td>
                        <td><?= htmlspecialchars($row['start_time']) ?></td>
                        <td><?= htmlspecialchars($row['end_time']) ?></td>
                        <td><?= isset($row['total_time']) && $row['total_time'] > 0 ? format_duration($row['total_time']) : 'N/D' ?></td>                        
                        <td><?= !empty($row['subscription_type']) ? htmlspecialchars($row['subscription_type']) : 'N/D' ?></td>
                        <td>
                            <?php
                                $servicesText = [];
                                foreach ($row['services'] as $service) {
                                    $servicesText[] = htmlspecialchars($service['service_name']) . " (" . intval($service['quantity']) . ")";
                                }
                                echo $servicesText ? implode(', ', $servicesText) : '—';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?section=old&page=<?= $page - 1 ?>">&laquo; Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?section=old&page=<?= $i ?>" class="<?= $i == $page ? 'current' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?section=old&page=<?= $page + 1 ?>">Suivant &raquo;</a>
        <?php endif; ?>
    </div>

    <?php endif; ?>
   

</body>
</html>
