<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Session Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        .summary {
            max-width: 650px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: #fff;
        }
        .home-btn {
            display: block;
            margin: 30px auto 0;
            background: #2980b9;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="summary">
    <h2>Session Summary</h2>
    <table>
        <tr><th>Full Name</th><td><?= htmlspecialchars($session['first_name'] . ' ' . $session['last_name']) ?></td></tr>
        <tr><th>Username</th><td><?= htmlspecialchars($session['username']) ?></td></tr>
        <tr><th>Phone</th><td><?= htmlspecialchars($session['phone_number']) ?></td></tr>
        <tr><th>Seat</th><td><?= htmlspecialchars($session['seat_number']) ?></td></tr>
        <tr><th>Start Time</th><td><?= htmlspecialchars($session['start_time']) ?></td></tr>
        <tr><th>End Time</th><td><?= htmlspecialchars($session['end_time']) ?></td></tr>
        <tr><th>Total Duration</th><td><?= $session['total_time'] ? format_duration($session['total_time']) : 'N/A' ?></td></tr>
        <tr><th>Session Price</th><td><?= number_format($session_price, 2) ?> TND</td></tr>
        <tr><th>Subscription Type</th><td><?= !empty($session['subscription_type']) ? htmlspecialchars($session['subscription_type']) : 'N/A' ?></td></tr>
    </table>

    <?php if (!empty($servicesProvided)): ?>
        <h2>Services Provided</h2>
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Price (dinar)</th>
                    <th>Quantity</th>
                    <th>Requested At</th>
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
        <p>No services were provided during this session.</p>
    <?php endif; ?>

    <a class="home-btn" href="index.php">Return to Dashboard</a>
</div>
</body>
</html>
