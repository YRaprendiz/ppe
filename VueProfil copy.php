<!-- VueProfil.php -->
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: VueLogin.php');
    exit;
}
$user = $_SESSION['user'];
?>
<title>Profil</title>
<?php include 'VueNavbar.php'; renderNavbar(); ?>

    <h1>Bienvenue, <?php echo htmlspecialchars($user['prenom']); ?> !</h1>
    <p>Nom : <?php echo htmlspecialchars($user['nom']); ?></p>
    <p>Email : <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Téléphone : <?php echo htmlspecialchars($user['telephone']); ?></p>
    <a href="VueLogout.php">Se déconnecter</a>

<?php renderFooter()?>