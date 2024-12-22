<!-- VueLogin.php -->
<?php
include('./ControllerUser.php');
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
<title>Connexion</title>
<?php include ('./VueNavbar.php'); renderNavbar(); ?>
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