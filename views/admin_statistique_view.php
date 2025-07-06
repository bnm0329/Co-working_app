<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard — Coworking Statistics</title>
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
      background: #f2f4f7;
      color: #333;
      margin: 0;
      padding: 20px;
    }
    h1, h2, h3 {
      color: #2c3e50;
      text-align: center;
    }
    .container {
      max-width: 1200px;
      margin: auto;
    }
    .tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    .tab-button {
      padding: 10px 18px;
      margin: 5px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    .tab-button:hover {
      background-color: #2c80b4;
    }
    .section {
      display: none;
    }
    .active {
      display: block;
    }
    .summary-cards {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-bottom: 30px;
    }
    .card {
      background: linear-gradient(to bottom right, #e3f2fd, #ffffff);
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      flex: 1;
      padding: 20px;
      min-width: 200px;
      text-align: center;
    }
    .card h3 {
      margin-bottom: 10px;
      color: #3498db;
    }
    .card p {
      font-size: 26px;
      font-weight: bold;
      margin: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0 40px;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    th, td {
      padding: 14px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #3498db;
      color: #fff;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 0.5px;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
    .highlight {
      color: green;
      font-weight: bold;
      font-size: 18px;
      text-align: center;
    }
     .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            text-align: center;

            
     }
  </style>
</head>
<body>
<div class="container">
    <a class="back-link" href="index.php">← Retour au Dashboard</a>

  <h1>📊 Admin Dashboard</h1>

  <div class="tabs">
    <button class="tab-button" onclick="showSection('overview')">Overview</button>
    <button class="tab-button" onclick="showSection('revenue')">Revenue</button>
    <button class="tab-button" onclick="showSection('subscriptions')">Subscriptions</button>
    <button class="tab-button" onclick="showSection('peak')">Peak Hours</button>
  </div>

  <!-- Overview -->
  <div id="overview" class="section active">
    <div class="summary-cards">
      <div class="card"><h3>Active Sessions</h3><p><?= $active_sessions ?></p></div>
      <div class="card"><h3>Completed Sessions</h3><p><?= $completed_sessions ?></p></div>
      <div class="card"><h3>Avg. Session Duration</h3><p><?= $avg_duration_formatted ?></p></div>
      <div class="card"><h3>Occupancy Rate</h3><p><?= $occupancy_rate ?>%</p></div>
      <div class="card"><h3>New Subscribers (7d)</h3><p><?= $new_subscribers ?></p></div>
    </div>
    <h2>Session Duration Distribution</h2>
    <table>
      <tr><th>0–30 min</th><th>30–60 min</th><th>Over 60 min</th></tr>
      <tr><td><?= $less_30 ?></td><td><?= $between_30_60 ?></td><td><?= $more_60 ?></td></tr>
    </table>
  </div>

<!-- Month/Year Selection Form -->
<div id="revenue" class="section">
  <div class="month-picker">
  <h2>View Revenue for Selected Month</h2>
 <center> <form method="GET" action="">
    <select name="selected_month">
      <?php for ($i=1; $i<=12; $i++): ?>
        <option value="<?= $i ?>" <?= $i == $selectedMonth ? 'selected' : '' ?>>
          <?= date('F', mktime(0,0,0,$i,1)) ?>
        </option>
      <?php endfor; ?>
    </select>
    <select name="selected_year">
      <?php for ($year = date('Y'); $year >= 2020; $year--): ?>
        <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>>
          <?= $year ?>
        </option>
      <?php endfor; ?>
    </select>
    <button type="submit">Apply</button>
  </form></center>
</div>
  <div class="tabs">
    <button class="tab-button active" onclick="switchRevenue('combined')">💰 Combined</button>
    <button class="tab-button" onclick="switchRevenue('sessions')">💻 Sessions</button>
    <button class="tab-button" onclick="switchRevenue('services')">🧾 Services</button>
    <button class="tab-button" onclick="switchRevenue('subscriptions')">📄 Subscriptions</button>
  </div>

  <div id="rev_combined" class="rev-tab">
    <h2>💰 Combined Revenue</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Today</h3>
          <p><?= number_format($combined_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>Past 7 Days</h3>
          <p><?= number_format($combined_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Month Total</h3>
        <p><?= number_format($combined_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Daily Revenue (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button  onclick="exportRevenueTableToCSV(this)" class="export">Export to CSV</button>
      <table>
        <thead>
          <tr><th>Date</th><th>Revenue</th></tr>
        </thead>
        <tbody>
          <?php if (!empty($combinedByDate)): ?>
            <?php foreach ($combinedByDate as $date => $amount): ?>
              <tr>
                <td><?= $date ?></td>
                <td><?= number_format($amount, 2) ?> TND</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="2">No revenue data for this period</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Session Revenue -->
  <div id="rev_sessions" class="rev-tab" style="display:none;">
    <h2>💻 Session Revenue</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Today</h3>
          <p><?= number_format($session_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>Past 7 Days</h3>
          <p><?= number_format($session_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Month Total</h3>
        <p><?= number_format($session_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Daily Session Revenue (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button onclick="exportRevenueTableToCSV(this)" class="export">Export to CSV</button>
      <table>
        <thead>
          <tr><th>Date</th><th>Revenue</th></tr>
        </thead>
        <tbody>
          <?php if (!empty($sessionByDate)): ?>
            <?php foreach ($sessionByDate as $date => $amount): ?>
              <tr>
                <td><?= $date ?></td>
                <td><?= number_format($amount, 2) ?> TND</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="2">No session revenue for this period</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Service Revenue -->
  <div id="rev_services" class="rev-tab" style="display:none;">
    <h2>🧾 Service Revenue</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Today</h3>
          <p><?= number_format($service_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>Past 7 Days</h3>
          <p><?= number_format($service_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Month Total</h3>
        <p><?= number_format($service_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Daily Service Revenue (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button onclick="exportRevenueTableToCSV(this)" class="export">Export to CSV</button>

      <table>
        <thead>
          <tr><th>Date</th><th>Revenue</th></tr>
        </thead>
        <tbody>
          <?php if (!empty($serviceByDate)): ?>
            <?php foreach ($serviceByDate as $date => $amount): ?>
              <tr>
                <td><?= $date ?></td>
                <td><?= number_format($amount, 2) ?> TND</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="2">No service revenue for this period</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Subscription Revenue -->
  <div id="rev_subscriptions" class="rev-tab" style="display:none;">
    <h2>📄 Subscription Revenue</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Today</h3>
          <p><?= number_format($sub_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>Past 7 Days</h3>
          <p><?= number_format($sub_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Month Total</h3>
        <p><?= number_format($sub_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Daily Subscription Revenue (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button onclick="exportRevenueTableToCSV(this)" class="export">Export to CSV</button>
      <table>
        <thead>
          <tr><th>Date</th><th>Revenue</th></tr>
        </thead>
        <tbody>
          <?php if (!empty($subByDate)): ?>
            <?php foreach ($subByDate as $date => $amount): ?>
              <tr>
                <td><?= $date ?></td>
                <td><?= number_format($amount, 2) ?> TND</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="2">No subscription revenue for this period</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function switchRevenue(type) {
  document.querySelectorAll('.tab-button').forEach(btn => {
    btn.classList.remove('active');
  });
  
  const indexMap = {
    'combined': 1,
    'sessions': 2,
    'services': 3,
    'subscriptions': 4
  };
  
  document.querySelector(`.tab-button:nth-child(${indexMap[type]})`).classList.add('active');
  
  document.querySelectorAll('.rev-tab').forEach(tab => {
    tab.style.display = 'none';
  });
  document.getElementById('rev_' + type).style.display = 'block';
}
</script>
  <div id="subscriptions" class="section">
    <h2>Subscription Types</h2>
    <table>
      <tr><th>Type</th><th>Count</th></tr>
      <?php foreach ($subscription_types as $sub): ?>
        <tr><td><?= ucfirst($sub['subscription_type']) ?></td><td><?= $sub['count'] ?></td></tr>
      <?php endforeach; ?>
    </table>

    <h2>Status Summary</h2>
    <table>
      <tr><th>Active</th><th>Expired</th></tr>
      <tr><td><?= $active_subs ?></td><td><?= $expired_subs ?></td></tr>
    </table>
  </div>

  <!-- Peak Hours -->
  <div id="peak" class="section">
    <h2>Peak Usage by Hour</h2>
    <table>
      <tr><th>Hour</th><th>Sessions</th></tr>
      <?php foreach ($peak_usage as $peak): ?>
        <tr>
          <td><?= str_pad($peak['hour'], 2, "0", STR_PAD_LEFT) ?>:00</td>
          <td><?= $peak['count'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<script>
  function showSection(id) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
  }
function exportRevenueTableToCSV(button) {
    const tab = button.closest('.rev-tab');
    const table = tab.querySelector('table');
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('th, td');
        let rowData = [];

        cols.forEach(col => {
            const text = col.innerText.replace(/"/g, '""'); // escape quotes
            rowData.push(`"${text}"`);
        });

        csv.push(rowData.join(","));
    });

    const csvBlob = new Blob([csv.join("\n")], { type: "text/csv" });
    const url = URL.createObjectURL(csvBlob);

    const filename = tab.querySelector('h2').innerText.replace(/[^a-z0-9]/gi, '_').toLowerCase() + "_" + new Date().toISOString().slice(0, 10) + ".csv";

    const a = document.createElement("a");
    a.setAttribute("href", url);
    a.setAttribute("download", filename);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

</script>

</body>
</html>
