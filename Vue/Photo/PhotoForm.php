<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') {
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

<h1>Gestion des Photos</h1>

<h2>Ajouter une Photo</h2>
<form action="../Controller/PhotoController.php" method="POST" enctype="multipart/form-data">
    <label for="image">Image :</label>
    <input type="file" name="image" id="image" required>

    <label for="description">Description :</label>
    <input type="text" name="description" id="description" required>

    <input type="hidden" name="action" value="ajouter">
    <input type="submit" value="Ajouter">
</form>

<h2>Liste des Photos</h2>
<?php foreach ($photos as $photo): ?>
    <div>
        <img src="data:image/jpeg;base64,<?= base64_encode($photo['Images']); ?>" alt="Photo" style="width: 100px; height: 100px;">
        <p>Description : <?= htmlspecialchars($photo['description']); ?></p>

        <form action="../Controller/PhotoController.php" method="POST">
            <input type="hidden" name="id" value="<?= $photo['ID_Photos']; ?>">
            <input type="text" name="description" value="<?= htmlspecialchars($photo['description']); ?>" required>
            <input type="hidden" name="action" value="modifier">
            <input type="submit" value="Modifier">
        </form>

        <form action="../Controller/PhotoController.php" method="POST">
            <input type="hidden" name="id" value="<?= $photo['ID_Photos']; ?>">
            <input type="hidden" name="action" value="supprimer">
            <input type="submit" value="Supprimer">
        </form>
    </div>
<?php endforeach; ?>
