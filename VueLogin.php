<!-- VueLogin.php -->
<?php
include('ControllerUser.php');
$controller = new ControllerUser();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($controller->loginUser($email, $password)) {
        header('Location: VueProfil.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
<?php include 'VueNavbar.php'; renderNavbar(); ?>
    <h1>Connexion</h1>
    <?php FlashMessage::display(); ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <p><a href="VueInscription.php">Créer un compte</a></p>
</body>
</html>