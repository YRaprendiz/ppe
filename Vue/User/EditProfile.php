<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: /ppe/Vue/User/UserLogin.php');
    exit();
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/UserModel.php');

$userModel = new UserModel($bdd);
$user = $userModel->getUserById($_SESSION['user']['ID_Utilisateur']);

if (!$user) {
    header('Location: /ppe/Vue/User/UserLogin.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier le Profil - PPE</title>
    <link rel="stylesheet" href="/ppe/assets/css/style.css">
</head>
<body>
    <div class="profile-edit-container">
        <h1>Modifier mon Profil</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/ppe/Controller/UserController.php" method="POST" class="profile-form">
            <input type="hidden" name="action" value="updateProfile">
            
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['Nom']); ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['Prenom']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Enregistrer les modifications</button>
                <a href="/ppe/Vue/User/UserProfil.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>
