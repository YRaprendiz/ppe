<!-- Vue/UserLogin.php          -->
<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to index
if (isset($_SESSION['user'])) {
    header('Location: /ppe/index.php');
    exit();
}

// Error messages
$error_messages = [
    'missing_fields' => 'Veuillez remplir tous les champs',
    'invalid_credentials' => 'Email ou mot de passe incorrect. <p class="text-center">Pas encore inscrit? <a href="/ppe/index.php?page=register">Créez un compte ici</a></p>',
    'system' => 'Une erreur système est survenue'
];
?>
<?php include('./Vue/header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">Login</h1>
                
                <?php if (isset($_GET['error']) && isset($error_messages[$_GET['error']])): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error_messages[$_GET['error']]); ?>
                    </div>
                <?php endif; ?>

                <form action="/ppe/Controller/UserController.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <input type="hidden" name="action" value="login">
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                    <p class="text-center">Pas encore inscrit? <a href="/ppe/index.php?page=register" class="btn btn-primary btn-block">Créez un compte ici</a></p>
                </form>
            </div>
        </div>
    </div>
<?php include('./Vue/footer.php'); ?>