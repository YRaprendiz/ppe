<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Client') {
    echo '<h1>Accès refusé</h1>';
    exit();
}
include('./Bdd/bdd.php');
include('./Model/UserModel.php');
$UtilisateurModel = new Utilisateur($bdd);
$Users = $UtilisateurModel->getUtilisateurById($id);

if (isset($_GET['message'])) echo '<p style="color: green;">' . htmlspecialchars($_GET['message']) . '</p>';
if (isset($_GET['error'])) echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
?>
<h2>Liste des Photos</h2>
<?php foreach ($Users as $User): ?>
    <div>
        <img src="data:image/jpeg;base64,<?= base64_encode($User['Images']); ?>" alt="Photo" style="width: 100px; height: 100px;">
        <p>Nom,Prenom,Email,Mdp,User_role</p>
    </div>
<?php endforeach; ?>
