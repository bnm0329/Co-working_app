<!DOCTYPE html>
<html>
<head>
    <title>Mon Space</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #3498db;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header a {
            color: #fff;
            font-weight: 500;
            text-decoration: none;
            background: #2980b9;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .header a:hover {
            background: #1c5980;
        }
        .content {
            padding: 30px;
        }
        .user-info {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }
        .user-info h2 {
            margin-top: 0;
            color: #2c3e50;
        }
        .user-info p {
            margin: 8px 0;
            line-height: 1.6;
        }
        .user-info button {
            background: #e74c3c;
            border: none;
            padding: 10px 20px;
            color: #fff;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .user-info button:hover {
            background: #c0392b;
        }
        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table thead {
            background: #3498db;
        }
        table thead th {
            color: #fff;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 14px;
        }
        table tbody tr {
            border-bottom: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        table tbody td {
            padding: 12px 15px;
            font-size: 14px;
        }
        .service-request-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .service-request-form input[type="number"] {
            width: 80px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }
        .service-request-form input[type="number"]:focus {
            border-color: #3498db;
        }
        .service-request-form button {
            background: #e67e22;
            border: none;
            padding: 8px 12px;
            color: #fff;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .service-request-form button:hover {
            background: #d35400;
        }
        #request-message {
            font-size: 16px;
            font-weight: 500;
            margin-top: 20px;
            color: #2c3e50;
        }
        @media (max-width: 768px) {
            .header { flex-direction: column; text-align: center; }
            .header h1 { margin-bottom: 10px; }
            .content { padding: 20px; }
        }
    </style>
   <script>
    var telegramBotToken = "<?php echo $telegramBotToken; ?>";
    var chatId = "<?php echo $telegramChatId; ?>";

    function sendTelegramNotification(actionType, serviceName, quantity) {
        var activeSeat = document.getElementById("active-seat").value || "Seat not available";
        var username = "<?php echo htmlspecialchars($user['username']); ?>";
        var fullName = "<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>";
        
        var message = "Seat: " + activeSeat + "\nUsername: " + username + "\nName: " + fullName;
        if (serviceName) {
            message += "\nService Requested: " + serviceName;
        }
        if (quantity) {
            message += "\nQuantity: " + quantity;
        }
        message += "\nAction: " + actionType;
        
        var telegramUrl = "https://api.telegram.org/bot" + telegramBotToken + "/sendMessage";
        
        fetch(telegramUrl, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                chat_id: chatId,
                text: message
            })
        })
        .then(response => response.json())
        .then(data => console.log("Notification sent:", data))
        .catch(error => console.error("Error sending notification:", error));
    }
  
    function verif() {
        sendTelegramNotification("Admin Assistance Requested", "", "");
    }
  
    function submitServiceRequest(event, form) {
        event.preventDefault();
        var serviceName = form.getAttribute("data-service-name") || "Unknown Service";
        var quantity = form.querySelector("input[name='quantity']").value || "";
        sendTelegramNotification("Service Request !", serviceName, quantity);
  
        var formData = new FormData(form);
        fetch('request_service.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('request-message').style.display = 'block';
            document.getElementById('request-message').innerHTML = data;
            form.reset();
        })
        .catch(error => {
            document.getElementById('request-message').style.display = 'block';
            document.getElementById('request-message').innerHTML = 'Error: ' + error;
        });
    }
</script>

</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mon Espace</h1>
            <a href="index.php">Se déconnecter</a>
        </div>

        <div class="content">
            <?php if($user): ?>
            <div class="user-info">
                <h2>Bienvenue, <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></h2>
                <p><strong>Téléphone :</strong> <?= htmlspecialchars($user['phone_number']) ?></p>
                <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p><strong>Abonnement :</strong> <?= ucfirst(htmlspecialchars($user['subscription_type'])) ?></p>
                <p><strong>Date de début :</strong> <?= htmlspecialchars($user['subscription_start_date']) ?></p>
                <p><strong>Date de fin :</strong> <?= htmlspecialchars($user['subscription_end_date']) ?></p>
                <p><strong>Pour obtenir de l'aide de l'administrateur :</strong></p>
                <button onclick="verif()">Envoyer</button>
            </div>

            <input type="hidden" id="active-seat" value="<?= htmlspecialchars($activeSeatNumber) ?>">

            <h2>Sessions précédentes</h2>
            <?php if ($resultSessions && $resultSessions->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                        <th>Durée totale</th>
                        <th>Services</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($session = $resultSessions->fetch_assoc()): ?>
                    <tr>
                        <td><?= $session['start_time'] ?></td>
                        <td><?= $session['end_time'] ?></td>
                        <td><?= $session['total_time'] ? gmdate("H:i:s", $session['total_time']) : "N/A" ?></td>
                        <td>
                            <?php
                            $sessionId = intval($session['session_id']);
                            $queryServ = "SELECT sr.quantity, sv.service_name 
                                          FROM service_requests sr 
                                          JOIN services sv ON sr.service_id = sv.service_id 
                                          WHERE sr.session_id = $sessionId AND sr.status = 'approved'";
                            $resultServ = $conn->query($queryServ);
                            $servicesList = [];
                            if ($resultServ && $resultServ->num_rows > 0) {
                                while($serviceRow = $resultServ->fetch_assoc()) {
                                    $servicesList[] = htmlspecialchars($serviceRow['service_name']) . " (" . intval($serviceRow['quantity']) . ")";
                                }
                            }
                            echo implode(", ", $servicesList);
                            ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

           

            <?php else: ?>
                <p>Aucune session précédente trouvée</p>
            <?php endif; ?>

            <h2>Services disponibles</h2>
            <?php
                $queryServices = "SELECT * FROM services";
                $resultServices = $conn->query($queryServices);
                $services = [];
                if ($resultServices) {
                    while ($row = $resultServices->fetch_assoc()) {
                        $services[] = $row;
                    }
                }
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom du service</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th>Quantité</th>
                        <th>Demander</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($services as $service): ?>
                    <tr>
                        <td><?= htmlspecialchars($service['service_name']) ?></td>
                        <td><?= htmlspecialchars($service['service_price']) ?> dinar</td>
                        <td>
                            <?php if($service['service_status'] === 'enabled'): ?>
                                <span style="color: green; font-weight: bold;">Disponible</span>
                            <?php else: ?>
                                <span style="color: red; font-weight: bold;">Indisponible</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($service['Quantity']) ?></td>
                        <td>
                            <?php if($service['service_status'] === 'enabled' && $service['Quantity'] > 0): ?>
                                <form class="service-request-form" onsubmit="submitServiceRequest(event, this);" data-service-name="<?= htmlspecialchars($service['service_name']) ?>">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <input type="hidden" name="service_id" value="<?= $service['service_id'] ?>">
                                    <input type="number" name="quantity" min="1" max="<?= $service['Quantity'] ?>" required>
                                    <button type="submit">Demander</button>
                                </form>
                            <?php else: ?>
                                <span style="color: red;">Indisponible</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p id="request-message"></p>
            <?php endif; ?>
        </div>
    </div>
</body>
