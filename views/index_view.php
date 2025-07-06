<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.85">
    <meta charset="UTF-8">
    <title>Co-Working Space Access</title>
    <link rel="stylesheet" href="./views/assets/css/main.css">
    <style>
      .alert {
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-color:red;
    padding: 12px;
    margin-top: 15px;
    text-align: center;
    color: #333;
    font-weight: bold;
    border-radius: 8px;
}

    .buttonS { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; margin: 5px; }</style>
    <script>
      function showSection(id) {
        ['section2', 'pricingSection', 'section3'].forEach(s => document.getElementById(s).style.display = s === id ? 'block' : 'none');
      }
      window.onload = function() {
        showSection('section2');
        const status = document.getElementById("statusMessage");
        if (status) setTimeout(() => status.style.display = 'none', 5000);
      };
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.getElementById('statusAlert');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 6000);
    }
});
</script>

    
</head>
<body>
<div class="logo-container">
    <img class="logo" src="./views/assets/images/logos.png?v=2" alt="Logo">
</div>
<div class="container">
    <?php if (!empty($notice)): ?>
    <div id="adminNotice">
        <h2>📢 Information Importante</h2>
        <p><?= htmlspecialchars($notice['message']) ?></p>
    </div>
    <?php endif; ?>

   
    <!-- Section 2 (default visible) -->
   <div id="section2" class="section">
    <div class="instructions-container">
        <center><h2>Bienvenue chez CoVILLA</h2></center>
        <h3>📌 Comment Accéder à l’Espace ?</h3><br>
        <p>Voici quelques règles essentielles pour une expérience optimale :</p><br>
        <ul>
            <li><strong>Espaces & Places :</strong> Choisissez une place disponible (🟢) et respectez le calme ambiant.</li>
            <li><strong>Connexion Internet :</strong> Utilisez votre coupon pour accéder au WiFi sécurisé. <em>(Un coupon = un appareil)</em></li>
            <li><strong>Services & Assistance :</strong> Demandez des services via l’espace client : 
                <strong><br>10.0.0.192/co-working/espace_client</strong>
            </li>
        </ul>

        <!-- Message de statut -->
        

        <!-- Ligne de boutons -->
        <div class="button-row" style="display: flex; justify-content: space-between; margin-top: 20px;">
            <form method="POST" action="">
                <button class="button" name="callAdmin" style="color:red;">Assistance Admin</button>
            </form>
            <button class="button" onclick="showSection('pricingSection')">Voir Nos Tarifs</button>
        </div>
        <?php if (!empty($statusMessage)): ?>
            <div class="alert" id="statusAlert"><?= htmlspecialchars($statusMessage) ?></div>
        <?php endif; ?>
    </div>
</div>

<!-- Script JS pour cacher le message après 3 sec -->



   <!-- Pricing Section -->
<div id="pricingSection" class="section" style="display:none;">
  <div class="pricing-box" style="max-width:600px; margin:auto; padding:16px; border:1px solid #ddd;">
    <h2>Tarifs CoVILLA - Simples &amp; Flexibles</h2>

    <strong>⏱️ Accès horaire :</strong>
    <table style="width:100%; margin:8px 0 20px; border-collapse:collapse;">
      <?php foreach ($hourly_pricing as $item): ?>
      <tr>
        <td style="padding:6px; border:1px solid #ddd;"><?= htmlspecialchars($item['label']) ?></td>
        <td style="padding:6px; border:1px solid #ddd;"><strong><?= number_format($item['price'], 2) ?> TND</strong></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <strong>📅 Abonnements :</strong>
    <table style="width:100%; margin:8px 0; border-collapse:collapse;">
      <?php foreach ($subscription_pricing as $item): ?>
      <tr>
        <td style="padding:6px; border:1px solid #ddd;"><?= htmlspecialchars($item['label']) ?></td>
        <td style="padding:6px; border:1px solid #ddd;"><strong><?= number_format($item['price'], 2) ?> TND</strong></td>
      </tr>
      <?php endforeach; ?>
    </table>

    💡 Restez libre, optimisez votre temps et travaillez sans stress chez <strong>CoVILLA</strong> !
  </div>
 
        <button id="continueBtn" class="button">Continuer</button>
    </div>

    <!-- Section 3 -->
    <div id="section3" class="section" style="display:none;">
        <h1>Bienvenue chez CoVilla 🚀</h1>
        <button class="button" onclick="window.location.href='dashboard.php'">Check-in</button>
        <div id="returningUserForm" class="form-container">
            <h2>Ouvrir Mon Espace</h2>
            <form action="client_space.php" method="post">
                <label>Entrez votre nom d'utilisateur :</label>
                <input type="text" name="username" required>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</div>
<script>
(function() {
  let clickCount = 0;
  const btn = document.getElementById('continueBtn');
  btn.addEventListener('click', function() {
    if (++clickCount >= 2) window.location.href = 'dashboard.php';
  });
})();
</script>
</body>
</html>
