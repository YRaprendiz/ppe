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
    'registration_failed' => 'L\'inscription a échoué. Veuillez réessayer.',
    'system' => 'Une erreur système est survenue'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription - PPE</title>
    <link rel="stylesheet" href="/ppe/assets/css/style.css">
</head>
<body>
    <div class="register-container">
        <h1>Inscription</h1>
        
        <?php if (isset($_GET['error']) && isset($error_messages[$_GET['error']])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_messages[$_GET['error']]); ?>
            </div>
        <?php endif; ?>

        <form action="/ppe/Controller/UserController.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="hidden" name="action" value="inscription">
            <button type="submit" class="btn-submit">S'inscrire</button>
        </form>

        <div class="login-link">
            Déjà inscrit? <a href="/ppe/Vue/User/UserLogin.php">Se connecter</a>
        </div>
    </div>
</body>
</html>
