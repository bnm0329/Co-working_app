<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gérer les tarifs</title>
  <link rel="stylesheet" href="../views/assets/css/admin_pricing.css">
  <script src="../views/assets/js/admin_pricing.js"></script>
</head>
<body>
<div class="container">
  <h1>Gestion des tarifs</h1>
  <div class="back-link">
    <a href="index">← Retour au tableau de bord</a>
  </div>

  <form method="post">
    <input type="hidden" name="id" value="">
    <div class="form-group">
      <label for="type">Type</label>
      <select name="type" id="type" required>
        <option value="hourly">À l'heure</option>
        <option value="subscription">Abonnement</option>
      </select>
    </div>
    <div class="form-group">
      <label for="label">Libellé</label>
      <input type="text" name="label" required>
    </div>
    <div class="form-group">
      <label for="duration_minutes">Durée (minutes) <small>(seulement pour l'heure)</small></label>
      <input type="number" name="duration_minutes">
    </div>
    <div class="form-group">
      <label for="price">Prix (TND)</label>
      <input type="number" step="0.01" name="price" required>
    </div>
    <input type="submit" value="Enregistrer le tarif">
  </form>

  <h2>Tarifs à l'heure</h2>
  <table>
    <tr>
      <th>Libellé</th>
      <th>Durée (min)</th>
      <th>Prix (TND)</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($pricing as $row): ?>
      <?php if ($row['type'] === 'hourly'): ?>
        <tr>
          <td><?= htmlspecialchars($row['label']) ?></td>
          <td><?= htmlspecialchars($row['duration_minutes']) ?></td>
          <td><?= htmlspecialchars($row['price']) ?></td>
          <td>
  <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Supprimer cette entrée ?')">Supprimer</a>
  <button type="button" onclick="editRow(
    '<?= $row['id'] ?>',
    '<?= $row['type'] ?>',
    '<?= htmlspecialchars($row['label'], ENT_QUOTES) ?>',
    <?= $row['duration_minutes'] !== null ? $row['duration_minutes'] : 'null' ?>,
    '<?= $row['price'] ?>'
  )" style="margin-left: 6px; padding: 5px 10px; border: none; background: #f39c12; color: white; border-radius: 4px; cursor: pointer;">Modifier</button>
</td>

        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>

  <h2>Tarifs d'abonnement</h2>
  <table>
    <tr>
      <th>Libellé</th>
      <th>Prix (TND)</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($pricing as $row): ?>
      <?php if ($row['type'] === 'subscription'): ?>
        <tr>
          <td><?= htmlspecialchars($row['label']) ?></td>
          <td><?= htmlspecialchars($row['price']) ?></td>
          <td>
  <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Supprimer cette entrée ?')">Supprimer</a>
  <button type="button" onclick="editRow(
    '<?= $row['id'] ?>',
    '<?= $row['type'] ?>',
    '<?= htmlspecialchars($row['label'], ENT_QUOTES) ?>',
    <?= $row['duration_minutes'] !== null ? $row['duration_minutes'] : 'null' ?>,
    '<?= $row['price'] ?>'
  )" style="margin-left: 6px; padding: 5px 10px; border: none; background: #f39c12; color: white; border-radius: 4px; cursor: pointer;">Modifier</button>
</td>

        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
