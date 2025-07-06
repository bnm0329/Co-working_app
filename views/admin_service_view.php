<!DOCTYPE html>
<html>
<head>
    <title>Services Management</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }
        .message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
        form {
            margin: 10px 0;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }
        input[type="submit"], .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }
        .add-btn {
            background: #3498db;
        }
        .add-btn:hover {
            background: #2980b9;
        }
        .update-btn {
            background: #28a745;
        }
        .update-btn:hover {
            background: #218838;
        }
        .disable-btn {
            background: #dc3545;
        }
        .disable-btn:hover {
            background: #c82333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #f4f4f4;
        }
        .tabs { margin-bottom: 20px; }
        .tabs a { margin-right: 15px; text-decoration: none; font-weight: bold; }
        .tabs a.active { color: blue; }
    </style>
    <style>
        /* Additional inline styles for this page */
        .tabs { margin-bottom: 20px; text-align: center; }
        .tabs a { margin-right: 15px; text-decoration: none; font-weight: bold; color: #3498db; }
        .tabs a.active { color: blue; }
        .action-btn {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 13px;
            transition: 0.3s;
            margin-right: 5px;
        }
        .approve-btn {
            background: #28a745;
        }
        .approve-btn:hover {
            background: #218838;
        }
        .reject-btn {
            background: #dc3545;
        }
        .reject-btn:hover {
            background: #c82333;
        }
        #ajax-message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            color: green;
        }
    </style>
    <script>
        function processRequest(request_id, action) {
            if (confirm("Are you sure you want to " + action + " this request?")) {
                fetch(action + "_request.php", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: "request_id=" + request_id
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('ajax-message').innerHTML = data;
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                })
                .catch(error => {
                    document.getElementById('ajax-message').innerHTML = "Error: " + error;
                });
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Service Management</h1>
        <?php if(isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <div class="tabs">
            <a href="index.php">Back to Dashboard</a>
            <a href="?section=active" class="<?php if($section=='active') echo 'active'; ?>">Add / Manage Services</a>
            <a href="?section=old" class="<?php if($section=='old') echo 'active'; ?>">Pending Service Requests</a>
        </div>
        
        <?php if($section=='active'): ?>
            <h2>Add New Service</h2>
            <form action="service.php" method="post">
                <label>Service Name:</label>
                <input type="text" name="service_name" required>
                <br>
                <label>Price (in dinar):</label>
                <input type="number" step="0.01" name="service_price" required>
                <br>
                <label>Quantity:</label>
                <input type="number" name="Quantity" required>
                <br>
                <input type="submit" name="add_service" value="Add Service" class="add-btn">
            </form>
            
            <h2>Existing Services</h2>
            <table>
                <tr>
                    <th>Service ID</th>
                    <th>Service Name</th>
                    <th>Price (dinar)</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php foreach($services as $service): ?>
                <tr>
                    <td><?php echo $service['service_id']; ?></td>
                    <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($service['service_price']); ?></td>
                    <td><?php echo htmlspecialchars($service['Quantity']); ?></td>
                    <td>
                        <?php if($service['service_status'] == 'enabled'): ?>
                            <span style="color: green; font-weight: bold;">Available</span>
                        <?php else: ?>
                            <span style="color: red; font-weight: bold;">Not Available</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Form to update service status and quantity -->
                        <form action="service.php" method="post" style="display:inline;">
                            <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                            <select name="service_status">
                                <option value="enabled" <?php if($service['service_status'] == 'enabled') echo 'selected'; ?>>Enable</option>
                                <option value="disabled" <?php if($service['service_status'] == 'disabled') echo 'selected'; ?>>Disable</option>
                            </select>
                            <input type="number" name="newQuantity" value="<?php echo $service['Quantity']; ?>" min="0" style="width:60px;">
                            <input type="submit" name="update_service" value="Update" class="update-btn">
                        </form>
                        <form action="service.php" method="post" style="display:inline;">
                            <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                            <input type="submit" name="delete_service" value="Delete" class="disable-btn" onclick="return confirm('Are you sure you want to delete this service?');">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else:  ?>
            <h2>Pending Service Requests</h2>
            <div id="ajax-message"></div>
            <table>
                <tr>
                    <th>Request ID</th>
                    <th>Client Name</th>
                    <th>Seat Number</th>
                    <th>Service Name</th>
                    <th>Price (dinar)</th>
                    <th>Quantity</th>
                    <th>Requested At</th>
                    <th>Action</th>
                </tr>
                    <?php if(!empty($pendingRequests)): ?>
                    <?php foreach($pendingRequests as $row): ?>
                        
                        <tr>
                            <td><?php echo $row['request_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['seat_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['service_price']); ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['requested_at']; ?></td>
                            <td>
                                <button onclick="processRequest(<?php echo $row['request_id']; ?>, 'approve')" class="action-btn approve-btn">Approve</button>
                                <button onclick="processRequest(<?php echo $row['request_id']; ?>, 'reject')" class="action-btn reject-btn">Reject</button>
                            </td>
                        </tr>
<?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">No pending requests found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
