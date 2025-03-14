
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
    'missing_fields' => 'Veuillez remplir tous les champs.',
    'registration_failed' => 'L\'inscription a échoué. Veuillez réessayer. Vérifiez s\'il existe déjà un compte enregistré sur la page de connexion.',
    'email_exists' => 'Ce e-mail est déjà enregistré. Veuillez en choisir un autre.',
    'system' => 'Une erreur système est survenue.',
];

?>

<?php include('./vue/header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1  class="text-center">Inscription</h1>
                
                <?php if (isset($_GET['error']) && isset($error_messages[$_GET['error']])): ?>
                    <div class="error-message" style="color: red; text-align: center;">
                        <?php echo htmlspecialchars($error_messages[$_GET['error']]); ?>
                    </div>
                <?php endif; ?>

                <form action="/ppe/Controller/AuthController.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required value="@gmail.com">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" required >
                    </div>
                   

                    <div class="form-group">
                        <label for="profileImage">Image de profil (optionnel)</label>
                        <input type="file" id="profileImage" name="profileImage" class="form-control" >
                    </div>

                    <input type="hidden" name="action" value="inscription">
                    <button type="submit" class="btn btn-primary btn-block ">S'inscrire</button>
                </form>
                    <?php
                    if ($_GET['error'] == 'missing_fields') {
                        echo '<p style="color: red; text-align: center;"><b>Tous les champs doivent être remplis.</b></p>';
                    } elseif ($_GET['error'] == 'email_exists') {
                        echo '<p style="color: red; text-align: center;"><b>Cet e-mail est déjà enregistré. Essayez-en un autre.</b></p>';
                    } elseif ($_GET['error'] == 'registration_failed') {
                        echo '<p style="color: red; text-align: center;"><b>Échec de l\'enregistrement de l\'utilisateur. Veuillez réessayer.</b></p>';
                    }
                    ?>
                </div>


                <div class="text-center">
                    Déjà inscrit? <a href="/ppe/Vue/Auth/AuthLogin.php" class="btn btn-primary btn-block">Se connecter</a>
                </div>
            </div>
        </div>
    </div>
<?php include('./Vue/footer.php'); ?>