<!-- ChambreForm.php-->
 <?php 

 if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') 
 {
    echo '<h1>Accès refusé</h1>';
    exit();
}
include('./Bdd/bdd.php');
include('./Model/ChambreModel.php');
$chambresModel = new chambresModel($bdd);
$chambres = $chambresModel->getAllChambres();

?>
 
<h1>Gestion des Chambres</h1>
    <form action="../Controller/ChambreController.php" method="POST">
        <input type="hidden" name="action" value="add">
        <label for="Images">Image :</label>
        <input type="file" name="Images" required>

        <label for="Chambre_000">Numéro Chambre :</label>
        <input type="text" name="Chambre_000" required>

        <label for="Type_Chambre">Type :</label>
        <select name="Type_Chambre">
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            <option value="Triple">Triple</option>
            <option value="Test4">Test4</option>
        </select>

        <label for="Stat">Statut :</label>
        <select name="Stat">
            <option value="Disponible">Disponible</option>
            <option value="Réservé">Réservé</option>
            <option value="Hors de service">Hors de service</option>
        </select>

        <label for="Prix">Prix :</label>
        <input type="number" step="0.01" name="Prix" required>
        
        <label for="Descriptif">Descriptif :</label>
        <textarea name="Descriptif" required></textarea>
        
        <button type="submit">Ajouter Chambre</button>
    </form>

    <h2>Liste des Chambres</h2>
    <ul>
        <?php foreach ($chambres as $chambre) : ?>
            <li>
            <img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']); ?>"alt="Photo" style="width: 100px; height: 100px;">
                <strong><?= $chambre['Chambre_000']; ?></strong>
                (<?= $chambre['Type_Chambre']; ?>) - <?= $chambre['Prix']; ?> €
                
                <form action="../Controller/ChambreController.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $chambre['ID_Chambres']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>