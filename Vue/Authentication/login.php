<?php
require_once './Controller/AuthUserController.php';

$authController = new AuthUserController();

// If already logged in, redirect to dashboard
if ($authController->isLoggedIn()) {
    header('Location: index.php?page=userProfil');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($authController->login($email, $password)) {
        header('Location: index.php?page=userProfil');
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<?php include('./Vue/header.php'); ?>
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>