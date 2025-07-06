<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Manage Seats</title>
    <link rel="stylesheet" href="../views/assets/css/main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 10px;
            font-size: 14px;
        }
        h1, h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 18px;
        }
        a {
            display: block;
            text-align: center;
            margin-bottom: 15px;
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            font-size: 15px;
        }
        form {
            background: #fff;
            padding: 10px;
            margin: 10px auto;
            max-width: 300px;
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            font-size: 13px;
        }
        input[type="text"], select {
            width: 90%;
            padding: 6px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 12px;
        }
        input[type="submit"] {
            padding: 8px 10px;
            border: none;
            border-radius: 3px;
            color: #fff;
            font-size: 12px;
            cursor: pointer;
        }
        .add-seat-btn {
            background: #28a745;
        }
        .add-seat-btn:hover {
            background: #218838;
        }
        .update-btn {
            background: #28a745;
        }
        .update-btn:hover {
            background: #218838;
        }
        .delete-btn {
            background: #dc3545;
        }
        .delete-btn:hover {
            background: #c82333;
        }
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .tabs button {
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }
        .tabs button.active {
            background: #2980b9;
        }
        .tab-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: none;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #3498db;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        @media (max-width: 768px) {
            table { width: 100%; }
            form { width: 90%; }
        }
    </style>
</head>
<body>
    <h1>Manage Seats</h1>
    <a href="index.php">Back to Dashboard</a>
    
    <h2>Add New Seat</h2>
    <form action="add_seat.php" method="post">
        <label>Seat Number:</label>
        <input type="text" name="seat_number" required>
        <input type="submit" value="Add Seat" class="add-seat-btn">
    </form>

    <table>
        <thead>
            <tr>
                <th>Seat Number</th>
                <th>Status</th>
                <th>Occupied By</th>
                <th>Subscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($seats as $seat): ?>
            <tr>
                <td><?= htmlspecialchars($seat['seat_number']) ?></td>
                <td><?= htmlspecialchars($seat['status']) ?></td>
                <td><?= ($seat['status'] === 'occupied' && !empty($seat['occupant'])) ? htmlspecialchars($seat['occupant']) : '—' ?></td>
                <td><?= !empty($seat['subscribe_type']) ? htmlspecialchars($seat['subscribe_type']) : '—' ?></td>
                <td>
                    <form action="update_seat.php" method="post">
                        <input type="hidden" name="seat_id" value="<?= $seat['seat_id'] ?>">
                        <select name="status">
                            <option value="available" <?= $seat['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="occupied" <?= $seat['status'] === 'occupied' ? 'selected' : '' ?>>Occupied</option>
                        </select>
                        <input type="submit" value="Update" class="update-btn">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
