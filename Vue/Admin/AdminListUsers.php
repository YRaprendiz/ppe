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
<?php include('header.php'); ?>
    <h2>Liste des Utilisateurs</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Photo</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['ID_Utilisateur']) ?></td>
                <td><?= htmlspecialchars($user['Nom']) ?></td>
                <td><?= htmlspecialchars($user['Prenom']) ?></td>
                <td><?= htmlspecialchars($user['Email']) ?></td>
                <td><?= htmlspecialchars($user['User_role']) ?></td>
                <td>
                    <?php if ($user['Images']): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($user['Images']); ?>" alt="Photo" style="width: 50px; height: 50px;">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php include '/xampp/htdocs/ppe/Vue/Footer.php';?>