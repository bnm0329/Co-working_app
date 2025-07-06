<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
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
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a.session-link { color: #2980b9; text-decoration: none; font-weight: bold; }
        a.session-link:hover { text-decoration: underline; }
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
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
.back-link { display:inline-block; margin-bottom: 20px; font-size: 16px; text-decoration: none; color: #007bff; }
        .back-link a { display:inline-block; margin-bottom: 20px; font-size: 16px; text-decoration: none; color: #007bff; }
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
       
    </style>
</head>
<body>
    <h1>Manage Users</h1>
    <center><a href="index.php" class="back-link"> &larr; Back to Dashboard</a></center><br><br>
    <button onclick="exportTableToCSV('old_sessions.csv')" class="export">Export to CSV</button>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Username</th>
                <th>User Type</th>
                <th>Subscription</th>
                <th>subscription start date</th>
                <th>Subscription End Date</th>
                <th>Created At</th>
                <th>Session History</th>
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
                                        <td><a class='session-link' href='user_sessions.php?username=<?= urlencode($user['username']) ?>'>View Sessions</a></td>


                </tr>
            <?php endforeach; ?>
        </tbody>
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
