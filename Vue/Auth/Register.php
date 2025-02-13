<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <form action="/c:/xampp/htdocs/ppe/Controller/AuthController.php" method="post">
        <input type="hidden" name="action" value="inscription">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <label for="prenom">Prenom:</label>
        <input type="text" id="prenom" name="prenom" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
