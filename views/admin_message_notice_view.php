<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panneau de gestion - Gestion des messages</title>
    <link rel="stylesheet" href="../views/assets/css/admin_message_notice.css">
</head>
<body>

<div class="container">
    <h2>Gestion des messages</h2>
    <div class="back-link">
        <p><a href="index">Retour au tableau de bord</a></p>
    </div>



    <form method="post">
        <input type="hidden" name="id" value="<?php echo isset($messageData['id']) ? $messageData['id'] : ''; ?>">

        <label for="message">Message :</label>
        <textarea name="message" required><?php echo isset($messageData['message']) ? $messageData['message'] : ''; ?></textarea>


        <button type="submit" class="button activate">
            <?php echo isset($messageData['id']) ? 'Mettre à jour le message' : 'Ajouter un nouveau message'; ?>
        </button>
    </form>

    <form method="get" style="margin-top: 20px;">
        <button type="submit" name="deactivate_all" class="button deactivate" onclick="return confirm('Êtes-vous sûr de vouloir désactiver tous les messages ?');">
            Désactiver tous les messages
        </button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Message</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($message = mysqli_fetch_assoc($messagesResult)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                    <td>
                        <?php echo $message['active'] == 1 ? 'Actif' : 'Inactif'; ?>
                    </td>
                    <td class="action-links">
                        <a href="?activate=<?php echo $message['id']; ?>" class="button activate">
                            <?php echo $message['active'] == 1 ? 'Désactiver' : 'Activer'; ?>
                        </a>
                        <a href="?edit=<?php echo $message['id']; ?>" class="button edit">Modifier</a>
                        <a href="?delete=<?php echo $message['id']; ?>" class="button deactivate" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>
