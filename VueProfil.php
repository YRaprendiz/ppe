<!-- VueProfil.php-->
<?php
include('./VueNavbar.php');
include('./ControllerUser.php');

if (!isset($_SESSION['user'])) {
    header('Location: VueLogin.php');
    exit;
}

$controller = new ControllerUser();
$user = $controller->getUserById($_SESSION['user']['id_user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $controller->updateUser($user['id_user'], $nom, $prenom, $email, $telephone);
    $user = $controller->getUserById($user['id_user']); // Mise à jour des données
}

renderNavbar();
?>
<div class="container my-5">
    <h1 class="text-center">Profil Utilisateur</h1>
    <?php FlashMessage::display(); ?>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="form-control" value="<?= htmlspecialchars($user['telephone']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
<?php renderFooter(); ?>
