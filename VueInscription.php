<!-- VueInscription.php -->
<?php
include('./VueNavbar.php');
include('./ControllerUser.php');
$controller = new ControllerUser();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telephone = $_POST['telephone'];
    if ($controller->inscriptionUser($nom, $prenom, $email, $password, $telephone)) {
        header('Location: VueLogin.php');
        exit;
    }
}
?>
<title>Inscription</title>
<?php  renderNavbar(); ?>
    <h1>Inscription</h1>
    <?php FlashMessage::display(); ?>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="text" name="telephone" placeholder="Téléphone" required>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="index.php?page=login">Connectez-vous ici</a></p>
<?php renderFooter() ?>