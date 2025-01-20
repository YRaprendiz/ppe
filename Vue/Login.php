<title>Connexion</title>

    <?php include 'Navbar.php' ?>
    <div class="container mt-5">
        <h1 class="text-center">Connexion</h1>
        <form action="../Controller/User.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <input type="hidden" name="action" value="login">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        <div class="mt-3 text-center">
            <p>Pas encore inscrit ? <a href="./Inscription.php">Créez un compte ici</a>.</p>
        </div>
    </div>
</body>
</html>
<!--
include('./ControllerUser.php');
include('./VueNavbar.php');
//include('./VueFooter.php');

$controller = new ControllerUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($controller->loginUser($email, $password)) {
        header('Location: index.php');
        exit;
    }
}

?>

<div class="container my-5">
    <h1>Connexion</h1>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
         FlashMessage::display(); 
    </form>
    <p><a href="VueInscription.php">Créer un compte</a></p>
</div>
renderFooter(); // Renderiza o rodapé
-->
