<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Pricing</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      padding: 20px;
    }
    .container {
      max-width: 960px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #2c3e50;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #3498db;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    input[type="text"], input[type="number"], select {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color: #2ecc71;
      color: white;
      border: none;
      padding: 10px 15px;
      cursor: pointer;
      border-radius: 4px;
    }
    .delete-btn {
      background: #e74c3c;
      color: white;
      padding: 5px 10px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 13px;
    }
    .delete-btn:hover {
      background: #c0392b;
    }
    .back-link {
      text-align: center;
      margin-bottom: 20px;
    }
    .back-link a {
      color: #3498db;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
  <script>
function editRow(id, type, label, duration, price) {
  document.querySelector('input[name="id"]').value = id;
  document.querySelector('select[name="type"]').value = type;
  document.querySelector('input[name="label"]').value = label;
  document.querySelector('input[name="duration_minutes"]').value = duration || '';
  document.querySelector('input[name="price"]').value = price;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

</head>
<body>
<div class="container">
  <h1>Pricing Management</h1>
  <div class="back-link">
    <a href="index.php">← Back to Dashboard</a>
  </div>

  <form method="post">
    <input type="hidden" name="id" value="">
    <div class="form-group">
      <label for="type">Type</label>
      <select name="type" id="type" required>
        <option value="hourly">Hourly</option>
        <option value="subscription">Subscription</option>
      </select>
    </div>
    <div class="form-group">
      <label for="label">Label</label>
      <input type="text" name="label" required>
    </div>
    <div class="form-group">
      <label for="duration_minutes">Duration (minutes) <small>(only for hourly)</small></label>
      <input type="number" name="duration_minutes">
    </div>
    <div class="form-group">
      <label for="price">Price (TND)</label>
      <input type="number" step="0.01" name="price" required>
    </div>
    <input type="submit" value="Save Pricing">
  </form>

  <h2>Hourly Pricing</h2>
  <table>
    <tr>
      <th>Label</th>
      <th>Duration (min)</th>
      <th>Price (TND)</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($pricing as $row): ?>
      <?php if ($row['type'] === 'hourly'): ?>
        <tr>
          <td><?= htmlspecialchars($row['label']) ?></td>
          <td><?= htmlspecialchars($row['duration_minutes']) ?></td>
          <td><?= htmlspecialchars($row['price']) ?></td>
          <td>
  <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this entry?')">Delete</a>
  <button type="button" onclick="editRow(
    '<?= $row['id'] ?>',
    '<?= $row['type'] ?>',
    '<?= htmlspecialchars($row['label'], ENT_QUOTES) ?>',
    <?= $row['duration_minutes'] !== null ? $row['duration_minutes'] : 'null' ?>,
    '<?= $row['price'] ?>'
  )" style="margin-left: 6px; padding: 5px 10px; border: none; background: #f39c12; color: white; border-radius: 4px; cursor: pointer;">Edit</button>
</td>

        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>

  <h2>Subscription Pricing</h2>
  <table>
    <tr>
      <th>Label</th>
      <th>Price (TND)</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($pricing as $row): ?>
      <?php if ($row['type'] === 'subscription'): ?>
        <tr>
          <td><?= htmlspecialchars($row['label']) ?></td>
          <td><?= htmlspecialchars($row['price']) ?></td>
          <td>
  <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this entry?')">Delete</a>
  <button type="button" onclick="editRow(
    '<?= $row['id'] ?>',
    '<?= $row['type'] ?>',
    '<?= htmlspecialchars($row['label'], ENT_QUOTES) ?>',
    <?= $row['duration_minutes'] !== null ? $row['duration_minutes'] : 'null' ?>,
    '<?= $row['price'] ?>'
  )" style="margin-left: 6px; padding: 5px 10px; border: none; background: #f39c12; color: white; border-radius: 4px; cursor: pointer;">Edit</button>
</td>

        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
