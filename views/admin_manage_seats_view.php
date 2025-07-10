<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les sièges</title>
    <link rel="stylesheet" href="../views/assets/css/main.css">
    <link rel="stylesheet" href="../views/assets/css/admin_manage_seats.css">
</head>
<body>
    <h1>Gérer les sièges</h1>
    <a href="index">Retour au tableau de bord</a>
    
    <h2>Ajouter un nouveau siège</h2>
    <form action="add_seat" method="post">
        <label>Numéro du siège :</label>
        <input type="text" name="seat_number" required>
        <input type="submit" value="Ajouter le siège" class="add-seat-btn">
    </form>

    <table>
        <thead>
            <tr>
                <th>Numéro du siège</th>
                <th>Statut</th>
                <th>Occupé par</th>
                <th>Abonnement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($seats as $seat): ?>
            <tr>
                <td><?= htmlspecialchars($seat['seat_number']) ?></td>
                <td><?= $seat['status'] === 'available' ? 'Disponible' : 'Occupé' ?></td>
                <td><?= ($seat['status'] === 'occupied' && !empty($seat['occupant'])) ? htmlspecialchars($seat['occupant']) : '—' ?></td>
                <td><?= !empty($seat['subscribe_type']) ? htmlspecialchars($seat['subscribe_type']) : '—' ?></td>
                <td>
                    <form action="update_seat" method="post">
                        <input type="hidden" name="seat_id" value="<?= $seat['seat_id'] ?>">
                        <select name="status">
                            <option value="available" <?= $seat['status'] === 'available' ? 'selected' : '' ?>>Disponible</option>
                            <option value="occupied" <?= $seat['status'] === 'occupied' ? 'selected' : '' ?>>Occupé</option>
                        </select>
                        <input type="submit" value="Mettre à jour" class="update-btn">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
