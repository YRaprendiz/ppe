<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'admin') {
    echo '<h1>Accès refusé</h1>';
    exit();
}
include('./Bdd/bdd.php');
include('./Model/PhotoModel.php');
$photoModel = new PhotoModel($bdd);
$photos = $photoModel->getPhotos();

if (isset($_GET['message'])) echo '<p style="color: green;">' . htmlspecialchars($_GET['message']) . '</p>';
if (isset($_GET['error'])) echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
?>
<h2>Liste des Photos</h2>
<?php foreach ($photos as $photo): ?>
    <div>
        <img src="data:image/jpeg;base64,<?= base64_encode($photo['Images']); ?>" alt="Photo" style="width: 100px; height: 100px;">
        <p>Description : <?= htmlspecialchars($photo['description']); ?></p>
    </div>
<?php endforeach; ?>
