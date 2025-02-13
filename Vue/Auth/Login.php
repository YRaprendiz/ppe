<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form action="/c:/xampp/htdocs/ppe/Controller/AuthController.php" method="post">
        <input type="hidden" name="action" value="login">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
