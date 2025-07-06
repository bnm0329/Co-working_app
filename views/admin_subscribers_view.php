<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestion des Abonnements</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <style>
        .export {
  padding: 6px 14px;
  margin: 10px 0;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.export:hover {
  background-color: #218838;
}
        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .tabs button {
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }
        .tabs button.active {
            background: #2980b9;
        }
        .tab-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: none;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #3498db;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #3498db;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #3498db;
            border: none;
            color: #fff;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
        }
    </style>
    <script>
        function showTab(tabName) {
            var tabs = document.getElementsByClassName("tab-content");
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
            
            var buttons = document.querySelectorAll(".tabs button");
            buttons.forEach(function(btn) {
                btn.classList.remove("active");
            });
            document.getElementById(tabName + "-btn").classList.add("active");
        }
        window.onload = function() {
            showTab("subscribers");
        }
    </script>
</head>
<body>
<h1>Gestion des Abonnements</h1>
<center><a class="back-link" href="index.php">← Retour au Dashboard</a></center>

<div class="tabs">
    <button id="subscribers-btn" onclick="showTab('subscribers')">Informations des abonnés</button>
    <button id="create-btn" onclick="showTab('create')">Créer Abonnement</button>
</div>
<div id="subscribers" class="tab-content">
    <h2>Informations des abonnés et progression</h2>
    <button onclick="exportTableToCSV('Subscription_historique.csv')" class="export">Export to CSV</button>
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
                $bar = str_repeat("🟥", $blocks) . " Expired";
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
                        <a href='update_subscription.php?user_id=" . $sub['user_id'] . "'>Mettre à jour</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    <style>
.pagination {
  margin-top: 20px;
  text-align: left;        /* Align links to the left */
  font-family: Arial, sans-serif;
}

.pagination a {
  display: inline-block;
  margin-right: 10px;
  padding: 6px 12px;
  color: #007BFF;
  text-decoration: none;
  border: 1px solid transparent;
  border-radius: 4px;
  transition: background-color 0.2s ease;
}

.pagination a:hover {
  background-color: #e9ecef;
  border-color: #007BFF;
}

.pagination a.current,
.pagination a[style*="font-weight:bold"] {
  font-weight: bold;
  color: #495057;
  border-color: #495057;
  background-color: #f0f0f0;
  cursor: default;
  pointer-events: none; /* Disable click on current page */
}
</style>

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
    <form action="subscribers.php" method="post">
        <div class="form-group">
            <label>Sélectionnez un utilisateur sans abonnement :</label>
            <select name="user_id" id="userSelect">
                <option value="">Sélectionnez</option>
                <?php
                $noSubQuery = "SELECT * FROM users WHERE subscription_type = 'none'";
                $noSubResult = $conn->query($noSubQuery);
                if ($noSubResult) {
                    while ($user = $noSubResult->fetch_assoc()) {
                        $fullName = htmlspecialchars($user['first_name'] . " " . $user['last_name']);
                        echo "<option value='" . $user['user_id'] . "'>$fullName</option>";
                    }
                }
                ?>
            </select>
        </div>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('userSelect');
    const inputsToToggle = document.querySelectorAll('.disable-if-user-selected');

    function toggleInputs() {
        const isUserSelected = userSelect.value !== '';
        inputsToToggle.forEach(input => {
            input.disabled = isUserSelected;
        });
    }

    // Initialize on page load
    toggleInputs();

    // Listen for changes
    userSelect.addEventListener('change', toggleInputs);
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
 
</body>
</html>
