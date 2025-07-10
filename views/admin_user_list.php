<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les utilisateurs</title>
    <link rel="stylesheet" href="../views/assets/css/admin_user_list.css">
    <script src="../views/assets/js/admin_user_list.js"></script>
</head>
<body>
    <h1>Gérer les utilisateurs</h1>
    <center><a href="index" class="back-link"> &larr; Retour au tableau de bord</a></center><br><br>
    <button onclick="exportTableToCSV('old_sessions.csv')" class="export">Exporter en CSV</button>
    <table>
        <thead>
            <tr>
                <th>Nom complet</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Nom d'utilisateur</th>
                <th>Type d'utilisateur</th>
                <th>Abonnement</th>
                <th>Date de début d'abonnement</th>
                <th>Date de fin d'abonnement</th>
                <th>Créé le</th>
                <th>Historique des sessions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></td>
                    <td><?= htmlspecialchars($user['phone_number']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['user_type']) ?></td>
                    <td><?= htmlspecialchars($user['subscription_type']) ?></td>
                                        <td><?= htmlspecialchars($user['subscription_start_date']) ?></td>

                    <td><?= htmlspecialchars($user['subscription_end_date']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td><a class='session-link' href='user_sessions?username=<?= urlencode($user['username']) ?>'>Voir les sessions</a></td>


                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?section=old&page=<?= $page - 1 ?>">&laquo; Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?section=old&page=<?= $i ?>" class="<?= $i == $page ? 'current' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?section=old&page=<?= $page + 1 ?>">Suivant &raquo;</a>
    <?php endif; ?>
</div>


<script>
function downloadCSV(csv, filename) {
    const csvFile = new Blob([csv], { type: "text/csv" });
    const downloadLink = document.createElement("a");

    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

function exportTableToCSV(filename) {
    const rows = document.querySelectorAll("table tr");
    let csv = [];

    rows.forEach(row => {
        const cols = row.querySelectorAll("td, th");
        const rowData = [];

        cols.forEach(col => {
            // Escape double quotes
            const data = col.innerText.replace(/"/g, '""');
            rowData.push(`"${data}"`);
        });

        csv.push(rowData.join(","));
    });

    downloadCSV(csv.join("\n"), filename);
}
</script>
 
</body>
</html>
