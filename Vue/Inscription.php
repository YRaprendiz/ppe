<title>Inscription</title>
<?php include 'Navbar.php' ?>
    <div class="container mt-5">
        <h1 class="text-center">Inscription</h1>
        <form action="../Controller/User.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <input type="hidden" name="action" value="inscription">
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
        <div class="mt-3 text-center">
            <p>Déjà inscrit ? <a href="./Login.php">Connectez-vous ici</a>.</p>
        </div>
    </div>
</body>
</html>

<!-- VueInscription.php 
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
 renderNavbar(); 
<div class="container my-5">
    <h1 class="text-center">Inscription</h1>
    
    FlashMessage::display(); 
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="text" name="telephone" placeholder="Téléphone" required>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
        <p>Déjà inscrit ? <a href="index.php?page=login">Connectez-vous ici</a></p>
        
        </div>
        -->