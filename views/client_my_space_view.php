<!DOCTYPE html>
<html>
<head>
    <title>Mon Space</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="views/assets/css/client_my_space_view.css">
    <script src="views/assets/js/client_my_space_view.js"></script>
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
