<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion des Abonnements</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../views/assets/css/admin_subscribers_view.css">
<script src="../views/assets/js/admin_subscribers_view.js"></script>
</head>

<body>
<h1>Gestion des Abonnements</h1>
<center><a class="back-link" href="index">← Retour au Dashboard</a></center>

<div class="tabs">
    <button id="subscribers-btn" onclick="showTab('subscribers')">Informations des abonnés</button>
    <button id="create-btn" onclick="showTab('create')">Créer Abonnement</button>
</div>
<div id="subscribers" class="tab-content">
    <h2>Informations des abonnés et progression</h2>
    <button onclick="exportTableToCSV('Subscription_historique.csv')" class="export">Exporter en CSV</button>
    <table>
        <tr>
            <th>Nom complet</th>
            <th>Username</th>
            <th>Téléphone</th>
            <th>Date de début</th>
            <th>Date de fin d'abonnement</th>
            <th>Type d'abonnement</th>
            <th>Progression</th>
            <th>Actions</th>
        </tr>
        <?php
        function getProgressBar($created_at, $subscription_end_date) {
            if (!$subscription_end_date || $subscription_end_date == "0000-00-00 00:00:00") {
                return "No Subscription";
            }
            $start = strtotime($created_at);
            $end = strtotime($subscription_end_date);
            $now = time();
            $total = $end - $start;
            $elapsed = $now - $start;
            if ($now >= $end) {
                $percentage = 100;
                $expired = true;
            } else {
                $percentage = ($elapsed / $total) * 100;
                $expired = false;
            }
            $blocks = 6;
            $used_blocks = floor(($percentage / 100) * $blocks);
            $empty_blocks = $blocks - $used_blocks;
            if ($expired) {
                $bar = str_repeat("🟥", $blocks) . " Expiré";
            } else {
                if ($percentage < 70) {
                    $color = "🟩";
                } elseif ($percentage < 90) {
                    $color = "🟧";
                } else {
                    $color = "🟥";
                }
                $bar = str_repeat($color, $used_blocks) . str_repeat("⬜", $empty_blocks) . " (" . round($percentage) . "%)";
            }
            return $bar;
        }
        foreach ($subscribers as $sub) {
            $displayEndDate = (empty($sub['subscription_end_date']) || $sub['subscription_end_date'] == '0000-00-00 00:00:00') ? "" : htmlspecialchars($sub['subscription_end_date']);
            $progressBar = getProgressBar($sub['subscription_start_date'], $sub['subscription_end_date']);
            $fullName = htmlspecialchars($sub['first_name'] . " " . $sub['last_name']);
            echo "<tr>
                    <td>$fullName</td>
                    <td>" . htmlspecialchars($sub['username']) . "</td>
                    <td>" . htmlspecialchars($sub['phone_number']) . "</td>
                    <td>" . htmlspecialchars($sub['subscription_start_date']) . "</td>
                    <td>$displayEndDate</td>
                    <td>" . htmlspecialchars($sub['subscription_type']) . "</td>
                    <td>$progressBar</td>
                    <td class='actions'>
                        <a href='update_subscription?user_id=" . $sub['user_id'] . "'>Mettre à jour</a>
                    </td>
                  </tr>";
        }
        ?>
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


</div>


   <div id="create" class="tab-content">
    <h2>Créer un Abonnement</h2>
    <form action="subscribers" method="post">
        <div class="form-group">
    <label for="userSearch">Rechercher un utilisateur sans abonnement :</label>
    <input type="text" id="userSearch" name="user_display" list="userList" class="form-control" placeholder="Nom d'utilisateur..." oninput="syncUserId()">
    <datalist id="userList">
        <?php
        $noSubQuery = "SELECT * FROM users WHERE subscription_type = 'none'";
        $noSubResult = $conn->query($noSubQuery);
        $userMap = []; // For mapping display name to user_id (in JS)
        if ($noSubResult) {
            while ($user = $noSubResult->fetch_assoc()) {
                $display = htmlspecialchars($user['username'] . "  " . $user['first_name'] . " " . $user['last_name']);
                echo "<option value=\"$display\">";
                $userMap[$display] = $user['user_id'];
            }
        }
        ?>
    </datalist>
    <input type="hidden" name="user_id" id="user_id"> <!-- this will hold the actual ID -->
</div>

<script>
    // JavaScript to map name to user_id
    const userMap = <?php echo json_encode($userMap); ?>;

    function syncUserId() {
        const input = document.getElementById('userSearch').value;
        const userIdField = document.getElementById('user_id');
        userIdField.value = userMap[input] || '';
    }
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('userSelect');
        const inputsToToggle = document.querySelectorAll('.disable-if-user-selected');

        function toggleInputs() {
            const isUserSelected = userSelect && userSelect.value !== '';
            inputsToToggle.forEach(input => {
                input.disabled = isUserSelected;
            });
        }

        // Initialize on page load
        toggleInputs();

        // Listen for changes
        if (userSelect) {
            userSelect.addEventListener('change', toggleInputs);
        }
    });
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


        <div class="form-group">
            <label>Prénom :</label>
            <input type="text" name="first_name" class="disable-if-user-selected">
        </div>

        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="last_name" class="disable-if-user-selected">
        </div>

        <div class="form-group">
            <label>Téléphone :</label>
            <input type="text" name="phone_number" class="disable-if-user-selected">
        </div>

        <div class="form-group">
            <label>Adresse email :</label>
            <input type="text" name="email" class="disable-if-user-selected">
        </div>

        <div class="form-group">
            <label>Type d'utilisateur :</label>
            <select name="user_type" class="disable-if-user-selected" required>
                <option value="">Sélectionnez</option>
                <option value="etudiant">Étudiant</option>
                <option value="lyceen">Lycéen</option>
                <option value="Free-lancer">Free-lancer</option>
            </select>
        </div>

        <div class="form-group">
            <label>Abonnement :</label>
            <select name="subscription" required>
                <option value="">Sélectionnez une durée</option>
                <option value="1_week">1 Semaine</option>
                <option value="2_weeks">2 Semaines</option>
                <option value="1_month">1 Mois</option>
            </select>
        </div>

        <input type="submit" value="Créer l'Abonnement">
    </form>
</div>


 
</body>
</html>
