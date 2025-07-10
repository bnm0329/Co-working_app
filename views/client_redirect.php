<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Redirection...</title>
</head>
<body>
    <form id="redirectForm" action="my_space.php" method="POST">
        <input type="hidden" name="username" value="<?= htmlspecialchars($_POST['username']) ?>">
    </form>
    <script src="../views/assets/js/client_redirect.js"></script>
</body>
</html>
