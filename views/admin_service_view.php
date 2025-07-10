<!DOCTYPE html>
<html>
<head>
    <title>Gestion des services</title>
    <link rel="stylesheet" href="../views/assets/css/admin_service.css">
    <script src="../views/assets/js/admin_service.js"></script>
</head>
<body>
    <div class="container">
        <h1>Gestion des services</h1>
        <?php if(isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <div class="tabs">
            <a href="index">Retour au tableau de bord</a>
            <a href="?section=active" class="<?php if($section=='active') echo 'active'; ?>">Ajouter / Gérer les services</a>
            <a href="?section=old" class="<?php if($section=='old') echo 'active'; ?>">Demandes de services en attente</a>
        </div>
        <?php if($section=='active'): ?>
            <h2>Ajouter un nouveau service</h2>
            <form action="service" method="post">
                <label>Nom du service :</label>
                <input type="text" name="service_name" required>
                <br>
                <label>Prix (en dinar) :</label>
                <input type="number" step="0.01" name="service_price" required>
                <br>
                <label>Quantité :</label>
                <input type="number" name="Quantity" required>
                <br>
                <input type="submit" name="add_service" value="Ajouter le service" class="add-btn">
            </form>
            <h2>Services existants</h2>
            <table>
                <tr>
                    <th>ID du service</th>
                    <th>Nom du service</th>
                    <th>Prix (dinar)</th>
                    <th>Quantité</th>
                    <th>Statut</th>
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
                            <span style="color: green; font-weight: bold;">Disponible</span>
                        <?php else: ?>
                            <span style="color: red; font-weight: bold;">Non disponible</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Formulaire pour mettre à jour le statut et la quantité du service -->
                        <form action="service" method="post" style="display:inline;">
                            <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                            <select name="service_status">
                                <option value="enabled" <?php if($service['service_status'] == 'enabled') echo 'selected'; ?>>Activer</option>
                                <option value="disabled" <?php if($service['service_status'] == 'disabled') echo 'selected'; ?>>Désactiver</option>
                            </select>
                            <input type="number" name="newQuantity" value="<?php echo $service['Quantity']; ?>" min="0" style="width:60px;">
                            <input type="submit" name="update_service" value="Mettre à jour" class="update-btn">
                        </form>
                        <form action="service" method="post" style="display:inline;">
                            <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                            <input type="submit" name="delete_service" value="Supprimer" class="disable-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else:  ?>
            <h2>Demandes de services en attente</h2>
            <div id="ajax-message"></div>
            <table>
                <tr>
                    <th>ID de la demande</th>
                    <th>Nom du client</th>
                    <th>Numéro du siège</th>
                    <th>Nom du service</th>
                    <th>Prix (dinar)</th>
                    <th>Quantité</th>
                    <th>Date de la demande</th>
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
                                <button onclick="processRequest(<?php echo $row['request_id']; ?>, 'approve')" class="action-btn approve-btn">Approuver</button>
                                <button onclick="processRequest(<?php echo $row['request_id']; ?>, 'reject')" class="action-btn reject-btn">Rejeter</button>
                            </td>
                        </tr>
<?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Aucune demande en attente trouvée.</td>
                    </tr>
                <?php endif; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
