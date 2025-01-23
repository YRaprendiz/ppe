<?php
if (!isset($_SESSION['user'])) {
    header('Location: /ppe/index.php?page=404');
    exit();
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/UserModel.php');

$userModel = new Utilisateur($bdd);
$user = $userModel->getUtilisateurById($_SESSION['user']['ID_Utilisateur']);

if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}
if (isset($_GET['erreur'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['erreur']) . '</div>';
}
?>

<div class="container mt-4">
    <h1>Mon Profil</h1>
    
    <?php if ($user): ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($user['Prenom']) . ' ' . htmlspecialchars($user['Nom']) ?></h5>
            <p class="card-text">
                <strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?><br>
                <strong>Rôle:</strong> <?= htmlspecialchars($user['User_role']) ?>
            </p>
            
            <!-- Formulaire de modification -->
            <form action="/ppe/Controller/UserController.php" method="POST" class="mt-4">
                <input type="hidden" name="action" value="modifier">
                <input type="hidden" name="id" value="<?= $user['ID_Utilisateur'] ?>">
                
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom:</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['Nom']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom:</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['Prenom']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="mdp" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer):</label>
                    <input type="password" class="form-control" id="mdp" name="mdp">
                </div>
                
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger">Utilisateur non trouvé.</div>
    <?php endif; ?>
</div>
