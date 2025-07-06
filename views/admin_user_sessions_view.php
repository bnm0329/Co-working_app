<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Session History – <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></title>
    <link rel="stylesheet" href="../views/assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background: #f5f5f5;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
    }
.back-link { text-align: center; margin-bottom: 20px; }
        .back-link a { color: #2980b9; text-decoration: none; font-weight: bold; }
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

    .tabs a {
        margin-right: 15px;
        text-decoration: none;
        font-weight: bold;
    }

    .tabs a.active {
        color: blue;
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

    


    .export {
        padding: 6px 14px;
        margin: 10px 0;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .export:hover {
        background-color: #218838;
    }

    button {
        margin: 10px 0;
        padding: 8px 16px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .actions a {
        margin-right: 10px;
        text-decoration: none;
        color: #3498db;
    }

    .actions a:hover {
        text-decoration: underline;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    input[type="text"], select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background: #3498db;
        border: none;
        color: #fff;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #3498db;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<h1>Session History for <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></h1>
<center><a href="manage_users.php" class="back-link">&larr; Back to Users</a></center>

<table>
    <thead>
        <tr>
            <th>Seat</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Total Duration</th>
            <th>Coupon Code</th>
            <th>MAC Address</th>
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
<td><?= $session['total_time'] ? format_duration($session['total_time']) : 'N/A' ?></td>                    <td><?= htmlspecialchars($session['coupon_code']) ?></td>
                    <td><?= htmlspecialchars($session['mac_address']) ?></td>
                    <td><span class="toggle-btn" onclick="toggleDetails(<?= $session['session_id'] ?>)">View Details</span></td>
                </tr>
                <tr id="details-<?= $session['session_id'] ?>" class="details">
                    <td colspan="8">
                        <strong>Services Requested:</strong>
                        <ul>
                            <?php if (!empty($session['services'])): ?>
                                <?php foreach ($session['services'] as $service): ?>
                                    <li>
                                        <?= intval($service['quantity']) ?>x 
                                        <?= htmlspecialchars($service['service_name']) ?> 
                                        (<?= htmlspecialchars($service['service_price']) ?> per unit) 
                                        – Requested at: <?= htmlspecialchars($service['requested_at']) ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No services used.</li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">No sessions found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
function toggleDetails(sessionId) {
    var row = document.getElementById("details-" + sessionId);
    row.style.display = (row.style.display === "table-row") ? "none" : "table-row";
}
</script>

</body>
</html>
