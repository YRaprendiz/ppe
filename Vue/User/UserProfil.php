<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/*
if (!isset($_SESSION['user'])) {
    header('Location: /ppe/Vue/User/UserLogin.php');
    exit();
}
*/
require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/UserModel.php');

$userModel = new UserModel($bdd);
$user = $userModel->getUserById($_SESSION['user']['ID_Utilisateur']);

?>
<?php include('./vue/header.php'); ?>
    <div class="profile-container"class="center">
        <h1>Mon Profil</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <?php if ($user): ?>
            <div class="profile-card">
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($user['Prenom'] . ' ' . $user['Nom']); ?></h2>
                    <div class="info-group">
                        <label>Email:</label>
                        <span><?php echo htmlspecialchars($user['Email']); ?></span>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="/ppe/Vue/User/EditProfile.php" class="btn-edit">Modifier le profil</a>
                    <form action="/ppe/Controller/UserController.php" method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="logout">
                        <button type="submit" class="btn-logout">Se déconnecter</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="error-message">
                Utilisateur non trouvé
            </div>
        <?php endif; ?>

        <div class="back-link">
            <a href="/ppe/index.php">Retour à l'accueil</a>
        </div>
    </div>
<?php include '/xampp/htdocs/ppe/Vue/Footer.php';?>