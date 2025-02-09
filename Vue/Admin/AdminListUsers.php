<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') {
    echo '<h1>Accès refusé</h1>';
    exit();
}
require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Controller/UserController.php');

$userController = new UserController($bdd);
$users = $userController->listUsers();

if (isset($_GET['message'])) echo '<p style="color: green;">' . htmlspecialchars($_GET['message']) . '</p>';
if (isset($_GET['error'])) echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';

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
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['message']) ?>
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
                                            <?php if ($user['Images']): ?>
                                                <img src="data:image/jpeg;base64,<?= base64_encode($user['Images']); ?>" 
                                                     alt="Photo" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            <?php else: ?>
                                                <span class="badge bg-secondary">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" class="btn btn-sm btn-warning">Modifier</a>
                                                <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
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
<?php include '/xampp/htdocs/ppe/Vue/Footer.php';?>