<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') {
    echo '<h1>Accès refusé</h1>';
    exit();
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Controller/UserController.php');

$userController = new UserController($bdd);
$users = $userController->listUsers();
?>

<?php include('/xampp/htdocs/ppe/Vue/Header.php'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="card-title text-center mb-0">Liste des Utilisateurs</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['success']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Photo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['ID_Utilisateur']) ?></td>
                                        <td><?= htmlspecialchars($user['Nom']) ?></td>
                                        <td><?= htmlspecialchars($user['Prenom']) ?></td>
                                        <td><?= htmlspecialchars($user['Email']) ?></td>
                                        <td><?= htmlspecialchars($user['User_role']) ?></td>
                                        <td>
                                            <?php if (!empty($user['Images'])): ?>
                                                <img src="data:image/jpeg;base64,<?= base64_encode($user['Images']); ?>" 
                                                     alt="Photo" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            <?php else: ?>
                                                <span class="badge bg-secondary">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="AdminEditUser.php?id=<?= $user['ID_Utilisateur'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="/ppe/Controller/UserController.php?action=delete&id=<?= $user['ID_Utilisateur'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                                                <a href="/ppe/Vue/User/UserProfil.php?id=<?= $user['ID_Utilisateur'] ?>" class="btn btn-sm btn-info">Voir Réservations</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Aucun utilisateur trouvé</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('/xampp/htdocs/ppe/Vue/Footer.php'); ?>