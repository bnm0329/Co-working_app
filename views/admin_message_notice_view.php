<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>message Panel - Manage Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .back-link {
            text-align: center;
            margin-top: 30px;
        }
        .back-link a {
            color: #2980b9;
            font-size: 16px;
            text-decoration: none;
            font-weight: bold;
        }
        .message-box {
            background: #dff0d8;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: green;
        }
        .error-box {
            background: #f2dede;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .button {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }
        .button:hover {
            opacity: 0.8;
        }
        .button.activate {
            background: green;
        }
        .button.deactivate {
            background: red;
        }
        .button.edit {
            background: #3498db;
        }
        .action-links {
            display: flex;
            justify-content: space-between;
        }
        .checkbox-container {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>message Message Management</h2>
    <div class="back-link">
        <p><a href="index.php">Back to Dashboard</a></p>
    </div>

    <?php if (isset($successMessage)): ?>
        <div class="message-box">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <div class="error-box">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo isset($messageData['id']) ? $messageData['id'] : ''; ?>">

        <label for="message">message Message:</label>
        <textarea name="message" required><?php echo isset($messageData['message']) ? $messageData['message'] : ''; ?></textarea>


        <button type="submit" class="button activate">
            <?php echo isset($messageData['id']) ? 'Update Message' : 'Add New Message'; ?>
        </button>
    </form>

    <form method="get" style="margin-top: 20px;">
        <button type="submit" name="deactivate_all" class="button deactivate" onclick="return confirm('Are you sure you want to deactivate all messages?');">
            Deactivate All Messages
        </button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($message = mysqli_fetch_assoc($messagesResult)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                    <td>
                        <?php echo $message['active'] == 1 ? 'Active' : 'Inactive'; ?>
                    </td>
                    <td class="action-links">
                        <a href="?activate=<?php echo $message['id']; ?>" class="button activate">
                            <?php echo $message['active'] == 1 ? 'Deactivate' : 'Activate'; ?>
                        </a>
                        <a href="?edit=<?php echo $message['id']; ?>" class="button edit">Edit</a>
                        <a href="?delete=<?php echo $message['id']; ?>" class="button deactivate" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>
