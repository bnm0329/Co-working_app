<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord admin — Statistiques coworking</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../views/assets/css/admin_statistique.css">
  <script src="../views/assets/js/admin_statistique.js"></script>
</head>
<body>
<div class="container">

  <h1>📊 Tableau de bord admin</h1>
     <center><a class="back-link" href="index">← Retour au tableau de bord</a></center>


  <div class="tabs">
    <button class="tab-button" onclick="showSection('overview')">Vue d'ensemble</button>
    <button class="tab-button" onclick="showSection('revenue')">Revenus</button>
    <button class="tab-button" onclick="showSection('subscriptions')">Abonnements</button>
    <button class="tab-button" onclick="showSection('peak')">Heures de pointe</button>
  </div>

  <!-- Overview -->
  <div id="overview" class="section active">
    <div class="summary-cards">
      <div class="card"><h3>Sessions actives</h3><p><?= $active_sessions ?></p></div>
      <div class="card"><h3>Sessions terminées</h3><p><?= $completed_sessions ?></p></div>
      <div class="card"><h3>Durée moyenne session</h3><p><?= $avg_duration_formatted ?></p></div>
      <div class="card"><h3>Taux d'occupation</h3><p><?= $occupancy_rate ?>%</p></div>
      <div class="card"><h3>Nouveaux abonnés (7j)</h3><p><?= $new_subscribers ?></p></div>
    </div>
    <h2>Distribution des durées de session</h2>
    <table>
      <tr><th>0–30 min</th><th>30–60 min</th><th>Plus de 60 min</th></tr>
      <tr><td><?= $less_30 ?></td><td><?= $between_30_60 ?></td><td><?= $more_60 ?></td></tr>
    </table>
  </div>

<!-- Month/Year Selection Form -->
<div id="revenue" class="section">
  <div class="month-picker">
  <h2>Voir les revenus pour le mois sélectionné</h2>
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
    <button type="submit">Appliquer</button>
  </form></center>
</div>
  <div class="tabs">
    <button class="tab-button active" onclick="switchRevenue('combined')">💰 Total</button>
    <button class="tab-button" onclick="switchRevenue('sessions')">💻 Sessions</button>
    <button class="tab-button" onclick="switchRevenue('services')">🧾 Services</button>
    <button class="tab-button" onclick="switchRevenue('subscriptions')">📄 Abonnements</button>
  </div>

  <div id="rev_combined" class="rev-tab">
    <h2>💰 Revenus totaux</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Aujourd'hui</h3>
          <p><?= number_format($combined_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>7 derniers jours</h3>
          <p><?= number_format($combined_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Total du mois</h3>
        <p><?= number_format($combined_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Revenu journalier (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button  onclick="exportRevenueTableToCSV(this)" class="export">Exporter en CSV</button>
      <table>
        <thead>
          <tr><th>Date</th><th>Revenu</th></tr>
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
            <tr><td colspan="2">Aucune donnée de revenu pour cette période</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Session Revenue -->
  <div id="rev_sessions" class="rev-tab" style="display:none;">
    <h2>💻 Revenu des sessions</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Aujourd'hui</h3>
          <p><?= number_format($session_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>7 derniers jours</h3>
          <p><?= number_format($session_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Total du mois</h3>
        <p><?= number_format($session_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Revenu journalier des sessions (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button onclick="exportRevenueTableToCSV(this)" class="export">Exporter en CSV</button>
      <table>
        <thead>
          <tr><th>Date</th><th>Revenu</th></tr>
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
            <tr><td colspan="2">Aucun revenu de session pour cette période</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Service Revenue -->
  <div id="rev_services" class="rev-tab" style="display:none;">
    <h2>🧾 Revenu des services</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Aujourd'hui</h3>
          <p><?= number_format($service_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>7 derniers jours</h3>
          <p><?= number_format($service_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Total du mois</h3>
        <p><?= number_format($service_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Revenu journalier des services (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button onclick="exportRevenueTableToCSV(this)" class="export">Exporter en CSV</button>
      <table>
        <thead>
          <tr><th>Date</th><th>Revenu</th></tr>
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
            <tr><td colspan="2">Aucun revenu de service pour cette période</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Subscription Revenue -->
  <div id="rev_subscriptions" class="rev-tab" style="display:none;">
    <h2>📄 Revenu des abonnements</h2>
    <div class="summary-cards">
      <?php if ($isCurrentMonth): ?>
        <div class="card">
          <h3>Aujourd'hui</h3>
          <p><?= number_format($sub_today, 2) ?> TND</p>
        </div>
        <div class="card">
          <h3>7 derniers jours</h3>
          <p><?= number_format($sub_7days, 2) ?> TND</p>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3>Total du mois</h3>
        <p><?= number_format($sub_month_total, 2) ?> TND</p>
      </div>
    </div>
    
    <h3>📅 Revenu journalier des abonnements (<?= date('F Y', strtotime($startOfMonth)) ?>)</h3>
<div class="table-container">
    <button onclick="exportRevenueTableToCSV(this)" class="export">Exporter en CSV</button>
      <table>
        <thead>
          <tr><th>Date</th><th>Revenu</th></tr>
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
            <tr><td colspan="2">Aucun revenu d'abonnement pour cette période</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

  <div id="subscriptions" class="section">
    <h2>Types d'abonnement</h2>
    <table>
      <tr><th>Type</th><th>Nombre</th></tr>
      <?php foreach ($subscription_types as $sub): ?>
        <tr><td><?= ucfirst($sub['subscription_type']) ?></td><td><?= $sub['count'] ?></td></tr>
      <?php endforeach; ?>
    </table>

    <h2>Résumé des statuts</h2>
    <table>
      <tr><th>Actifs</th><th>Expirés</th></tr>
      <tr><td><?= $active_subs ?></td><td><?= $expired_subs ?></td></tr>
    </table>
  </div>

  <!-- Peak Hours -->
  <div id="peak" class="section">
    <h2>Heures de pointe</h2>
    <table>
      <tr><th>Heure</th><th>Sessions</th></tr>
      <?php foreach ($peak_usage as $peak): ?>
        <tr>
          <td><?= str_pad($peak['hour'], 2, "0", STR_PAD_LEFT) ?>:00</td>
          <td><?= $peak['count'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

</body>
</html>
