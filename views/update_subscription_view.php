<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Subscription</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            margin: 40px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: 500;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[readonly] {
            background: #eee;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #3498db;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .message {
            text-align: center;
            color: green;
            margin-top: 20px;
            font-weight: bold;
        }
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Subscription</h1>
        <?php if($message != ""): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="update_subscription.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" value="<?php echo $user['first_name'] . " " . $user['last_name']; ?>" readonly>
            
            <label for="coupon">Coupon Code:</label>
            <input type="text" id="coupon" value="<?php echo $user['username']; ?>" readonly>
            
            <label for="current_subscription">Current Subscription:</label>
            <input type="text" id="current_subscription" value="<?php echo ucfirst($user['subscription_type']); ?>" readonly>
            
            <label for="current_end_date">Current Subscription End Date:</label>
            <input type="text" id="current_end_date" value="<?php echo ($user['subscription_end_date'] && $user['subscription_end_date'] != '0000-00-00 00:00:00') ? $user['subscription_end_date'] : ""; ?>" readonly>
            
            <label for="subscription">New Subscription:</label>
            <select name="subscription" id="subscription" required>
                <option value="">Select a new subscription period</option>
                <option value="1_week">1 Semaine</option>
                <option value="2_weeks">2 Semaines</option>
                <option value="1_month">1 Mois</option>
                <option value="none">Retirer l'abonnement</option>
            </select>
            
            <input type="submit" value="Update Subscription">
        </form>
        <a class="back-btn" href="subscribers.php">Back to Subscribers</a>
    </div>
</body>
</html>
