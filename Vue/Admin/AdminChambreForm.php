<!-- ChambreForm.php-->
 <?php 

 if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') 
 {
    echo '<h1>Accès refusé</h1>';
    exit();
 }
require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Controller/ChambreController.php');

// Initialize controller and get all rooms
$controller = new ChambresController($bdd);
$chambres = $controller->getAllChambres();
?>
 <?php include('./vue/header.php'); ?>
<h1>Gestion des Chambres</h1>
    <form action="/ppe/Controller/ChambreController.php" method="POST" enctype="multipart/form-data">
        
        <label for="Images">Image :</label>
        <input type="file" name="Images" ><!--required -->   <!-- --><br>

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
        <input type="number" step="0.01" name="Prix" ><!--required -->
        
        <label for="Descriptif">Descriptif :</label>
        <textarea name="Descriptif" ></textarea> <!-- required-->
        
        <input type="hidden" name="action" value="add">
        <button type="submit">Ajouter Chambre</button>
    </form>

    <h2>Liste des Chambres</h2>
    <ul>
        <?php if ($chambres && is_array($chambres)) : ?>
            <?php foreach ($chambres as $chambre) : ?>
                <li>
                    <strong><?= htmlspecialchars($chambre['ID_Chambres']); ?></strong>
                    (<?= htmlspecialchars($chambre['Type_Chambre']); ?>) - <?= htmlspecialchars($chambre['Prix']); ?> €
               
                 <?php if (isset($chambre['Images']) && $chambre['Images']) : ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']); ?>"alt="Photo" style="width: 100px; height: 100px;">
                <?php endif; ?>
                <form action="/ppe/Controller/ChambreController.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $chambre['ID_Chambres']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
    </ul>
<p>//footer</p>