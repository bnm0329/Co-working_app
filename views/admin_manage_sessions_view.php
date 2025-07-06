<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Session History</title>
        <link rel="stylesheet" href="../views/assets/css/admin_main.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">

    <style>
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
.back-link { text-align: center; margin-bottom: 20px; }
        .back-link a { color: #2980b9; text-decoration: none; font-weight: bold; }
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

    .tabs a {
        margin-right: 15px;
        text-decoration: none;
        font-weight: bold;
    }

    .tabs a.active {
        color: blue;
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

    button {
        margin: 10px 0;
        padding: 8px 16px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
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

    .back-link:hover {
        text-decoration: underline;
    }
</style>

    <script>
        function stopSession(sessionId, seatId) {
            if (confirm("Are you sure you want to stop this session?")) {
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "stop_timer.php";

                var inputSession = document.createElement("input");
                inputSession.type = "hidden";
                inputSession.name = "session_id";
                inputSession.value = sessionId;
                form.appendChild(inputSession);

                var inputSeat = document.createElement("input");
                inputSeat.type = "hidden";
                inputSeat.name = "seat_id";
                inputSeat.value = seatId;
                form.appendChild(inputSeat);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>
<body>
    <h1>Session History</h1>
   <center><a href="index.php" class="back-link">&larr; Back to Dashboard</a></center>

    <div class="tabs">
        <a href="?section=active" class="<?= $section === 'active' ? 'active' : '' ?>">Active Sessions</a>
        <a href="?section=old" class="<?= $section === 'old' ? 'active' : '' ?>">Old Sessions</a>

        
    </div>

    <?php if ($section === 'active'): ?>
        <h2>Active Sessions</h2>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Seat</th>
                    <th>Start Time</th>
                    <th>subscription </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activeSessions as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
<td>
    <select id="seatSelect_<?= $row['session_id'] ?>">
        <?php foreach ($availableSeats as $seat): ?>
            <option value="<?= $seat['seat_id'] ?>" <?= $seat['seat_number'] == $row['seat_number'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($seat['seat_number']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button onclick="updateSeat(<?= $row['session_id'] ?>)">Save</button>
</td>
                        <td><?= htmlspecialchars($row['start_time']) ?></td>
                        <td><?= !empty($row['subscription_type']) ? htmlspecialchars($row['subscription_type']) : 'N/A' ?></td>
                        <td><button onclick="stopSession(<?= $row['session_id'] ?>, <?= $row['seat_id'] ?>)">Stop Session</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <h2>Old Sessions</h2>
        <button onclick="exportTableToCSV('old_sessions.csv')" class="export">Export to CSV</button>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Seat</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Duration</th>
                    <th>subscription_type</th>
                    <th>Services Provided</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($oldSessions as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['seat_number']) ?></td>
                        <td><?= htmlspecialchars($row['start_time']) ?></td>
                        <td><?= htmlspecialchars($row['end_time']) ?></td>
                        <td><?= isset($row['total_time']) && $row['total_time'] > 0 ? format_duration($row['total_time']) : 'N/A' ?></td>                        
                        <td><?= !empty($row['subscription_type']) ? htmlspecialchars($row['subscription_type']) : 'N/A' ?></td>
                        <td>
                            <?php
                                $servicesText = [];
                                foreach ($row['services'] as $service) {
                                    $servicesText[] = htmlspecialchars($service['service_name']) . " (" . intval($service['quantity']) . ")";
                                }
                                echo $servicesText ? implode(', ', $servicesText) : '—';
                            ?>
                        </td>
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

    <?php endif; ?>
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
<script>
function updateSeat(sessionId) {
    const select = document.getElementById("seatSelect_" + sessionId);
    const newSeatId = select.value;

    fetch("../controllers/update_seat.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `session_id=${sessionId}&seat_id=${newSeatId}`
    })
    .then(response => response.text())
    .then(result => {
        alert(result.trim());
        location.reload();
    })
    .catch(error => {
        console.error("Error updating seat:", error);
        alert("An error occurred.");
    });
}
</script>

</body>
</html>
