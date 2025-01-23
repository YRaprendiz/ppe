<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') {
    echo '<h1>Accès refusé</h1>';
    exit();
}
require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Controller/PhotoController.php');
require_once(__DIR__ . '/../../Controller/ChambreController.php');

$modelePhoto = new PhotoModel($bdd);
$photos = $modelePhoto->getPhotos();

$controleurChambre = new ChambresController($bdd);
$chambres = $controleurChambre->getAllChambres();

if (isset($_GET['message'])) echo '<p style="color: green;">' . htmlspecialchars($_GET['message']) . '</p>';
if (isset($_GET['erreur'])) echo '<p style="color: red;">' . htmlspecialchars($_GET['erreur']) . '</p>';
?>

<h1>Gestion des Photos</h1>

<h2>Ajouter une Photo</h2>
<form action="/ppe/Controller/PhotoController.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="ajouter">
    
    <div>
        <label for="image">Image :</label>
        <input type="file" name="image" id="image" required>
    </div>
    
    <div>
        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>
    </div>

    <div>
        <label for="id_chambre">Chambre :</label>
        <select name="id_chambre" id="id_chambre">
            <option value="">Sélectionnez une chambre</option>
            <?php foreach ($chambres as $chambre): ?>
                <option value="<?= htmlspecialchars($chambre['ID_Chambres']); ?>">
                    Chambre <?= htmlspecialchars($chambre['ID_Chambres']); ?> 
                    (<?= htmlspecialchars($chambre['Type_Chambre']); ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Ajouter</button>
</form>

<h2>Liste des Photos</h2>
<div class="photos-list">
    <?php foreach ($photos as $photo): ?>
        <div class="photo-item">
            <img src="data:image/jpeg;base64,<?= base64_encode($photo['Images']); ?>" alt="Photo" style="width: 100px; height: 100px;">
            <p>Description : <?= htmlspecialchars($photo['Description']); ?></p>
            <p>Chambre : <?= $photo['ID_Chambre'] ? 'Chambre ' . htmlspecialchars($photo['ID_Chambre']) . 
                ' (' . htmlspecialchars($photo['Type_Chambre']) . ')' : 'Non assignée'; ?></p>
            
            <form action="/ppe/Controller/PhotoController.php" method="POST" style="display:inline;">
                <input type="hidden" name="action" value="supprimer">
                <input type="hidden" name="id" value="<?= $photo['ID_Photos']; ?>">
                <button type="submit">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
