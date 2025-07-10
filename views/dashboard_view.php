<!DOCTYPE html>
<html>
<head>
    <title>Co-Working Space Access</title>
    <link rel="stylesheet" href="./views/assets/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.80">
    <link rel="stylesheet" href="views/assets/css/dashboard_view.css">
    <script src="views/assets/js/dashboard_view.js"></script>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="./views/assets/images/logos.png?v=2" alt="Logo">
</div>
<div class="container">
    <h1>Bienvenue chez CoVilla 🚀</h1>

    <div id="buttonContainer">
        <button class="button" onclick="showForm('newUserForm')">Nouvel Utilisateur</button>
        <button class="button" onclick="showForm('returningUserForm')">Ancien Utilisateur</button>
    </div>

    <div id="newUserForm" class="form-container" style="display:none;">
        <h2>Inscription Nouvel Utilisateur</h2>
        <form action="./register" method="post">
            <label>Nom : <span style="color: red;">*</span></label>
            <input type="text" name="last_name" required>
            <label>Prénom : <span style="color: red;">*</span></label>
            <input type="text" name="first_name" required>
            <label>Numéro de téléphone :</label>
            <input type="tel" name="phone_number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <label>Adresse email : <span style="color: red;">*</span></label>
            <input type="email" name="email" required>
            <div class="checkbox-container">
                <input type="checkbox" name="newsletter" id="newsletter">
                <label for="newsletter">Je souhaite recevoir les nouveautés et offres par email.</label>
            </div>
            <label>Type d'utilisateur : <span style="color: red;">*</span></label>
            <select name="user_type" required>
                <option value="" disabled selected>Choisissez un type</option>
                <option value="etudiant">étudiant(e)</option>
                <option value="lyceen">lycéen(ne)</option>
                <option value="free-lancer">Free-lancer</option>
            </select>
            <input type="submit" value="S'inscrire & Générer le Nom d'Utilisateur">
        </form>
    </div>

    <div id="returningUserForm" class="form-container" style="display:none;">
        <h2>Se reconnecter</h2>
        <form action="./login" method="post">
            <label>Adresse e-mail ou nom d'utilisateur :</label>
            <input type="text" name="username" required>
            <input type="submit" value="Connexion">
        </form>
    </div>

    <?php if (!empty($message)): ?>
        <p id="successMessage" class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</div>
</body>
</html>
