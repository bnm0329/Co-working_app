<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Co-Working Space Access</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/assets/css/main.css">
    <style>
        /* Include your existing CSS styles here */
        p.guidance { text-align: left; font-size: 14px; line-height: 1.5; color: black; margin-bottom: 20px; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; text-align: center; color: #333; }
        .container { max-width: 500px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        h1, h2 { color: #2c3e50; }
        .form-container { display: block; text-align: left; margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], select { width: 95%; padding: 8px; font-size: 14px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; }
        input[type="submit"] { padding: 10px; font-size: 14px; margin-top: 10px; border: none; border-radius: 4px; color: white; background: #3498db; cursor: pointer; transition: 0.3s; }
        input[type="submit"]:hover { background: #2980b9; }
        .message { color: #fff; background: red; padding: 10px; font-weight: bold; border-radius: 5px; margin-top: 10px; display: inline-block; opacity: 1; transition: opacity 1s ease-in-out; }
    </style>
    <script>
        window.onload = function() {
            const message = document.getElementById("errorMessage");
            if (message) {
                setTimeout(() => { message.style.opacity = "0"; }, 2500);
            }
        };
    </script>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="../views/assets/images/logos.png?v=2" alt="Logo">
</div>
<div class="container">
    <h1>Bienvenue à Co-villa 🚀</h1>

        <div id="formResponse" style="margin-top: 10px;"></div>


    <div id="returningUserForm" class="form-container">
    <h2>Ouvrir mon espace</h2>
    <form id="loginForm">
        <label>Entrez votre nom d'utilisateur :</label>
        <input type="text" placeholder="prénom-Nom-Type d'utilisateur N°" name="username" required>
        <input type="submit" value="Connexion">
    </form>
</div>


    <p class="guidance">
        <strong>Mon espace :</strong> Accédez à votre espace personnel pour consulter votre historique d'utilisation, contacter notre administrateur et explorer les services que nous proposons.
    </p>
</div>
<script>
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const responseBox = document.getElementById("formResponse");

    responseBox.innerHTML = "";

    fetch("../controllers/MySpaceController.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        responseBox.innerHTML = data;
    })
    .catch(err => {
        responseBox.innerHTML = "Erreur de connexion au serveur.";
    });
});
</script>

</body>
</html>
