<!DOCTYPE html>
<html>
<head>
    <title>Co-Working Space Access</title>
    <link rel="stylesheet" href="./views/assets/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.80">
    <script>
        function showForm(formId) {
            const h1 = document.querySelector('h1');
            const newUserForm = document.getElementById("newUserForm");
            const returningUserForm = document.getElementById("returningUserForm");
            const selectedForm = document.getElementById(formId);

            if (selectedForm.style.display === "block") {
                selectedForm.style.display = "none";
                h1.style.display = "block";
            } else {
                newUserForm.style.display = "none";
                returningUserForm.style.display = "none";
                h1.style.display = "none";
                selectedForm.style.display = "block";
            }
        }

        window.onload = function () {
            const msg = document.getElementById("successMessage");
            if (msg) {
                setTimeout(() => msg.style.opacity = "0", 5000);
            }
        };
    </script>
    <style>
        input, select {
            width: 100%; padding: 10px; font-size: 16px;
            border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;
        }
        .checkbox-container {
            display: flex; align-items: center; margin-top: 8px;
        }
        .checkbox-container input[type="checkbox"] {
            width: 18px; height: 18px; margin-right: 10px; cursor: pointer;
            accent-color: #007bff;
        }
        .checkbox-container label {
            font-size: 14px; color: #333; cursor: pointer;
        }
        input[type="submit"] {
            background-color: #007bff; color: white;
            padding: 12px; border: none; border-radius: 5px; cursor: pointer;
        }
        input[type="submit"]:hover { background-color: #0056b3; }
    </style>
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
        <form action="./register.php" method="post">
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
        <form action="./login.php" method="post">
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
