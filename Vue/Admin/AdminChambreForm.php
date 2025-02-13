<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') {
    echo '<h1>Accès refusé';
    if (isset($_SESSION['user']['Email'])) {
        echo ' ' . htmlspecialchars($_SESSION['user']['Email']);
    }
    echo '.</h1>';
    exit();
}
require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Controller/ChambreController.php');

// Initialize controller and get all rooms
$controller = new ChambresController($bdd);
$chambres = $controller->getAllChambres();
?>
<?php include('/xampp/htdocs/ppe/Vue/Header.php'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="card-title text-center mb-0">Gestion des Chambres</h1>
                </div>
                <div class="card-body">
                    <form action="../../Controller/ChambreController.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="Images" class="form-label">Image :</label>
                            <input type="file" class="form-control" name="Images" id="Images">
                        </div>

                        <div class="mb-3">
                            <label for="Type_Chambre" class="form-label">Type :</label>
                            <select class="form-select" name="Type_Chambre" id="Type_Chambre">
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                                <option value="Triple">Triple</option>
                                <option value="Test4">Test4</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Stat" class="form-label">Statut :</label>
                            <select class="form-select" name="Stat" id="Stat">
                                <option value="Disponible">Disponible</option>
                                <option value="Réservé">Réservé</option>
                                <option value="Hors de service">Hors de service</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Prix" class="form-label">Prix :</label>
                            <input type="number" step="0.01" class="form-control" name="Prix" id="Prix">
                        </div>
                        
                        <div class="mb-3">
                            <label for="Descriptif" class="form-label">Descriptif :</label>
                            <textarea class="form-control" name="Descriptif" id="Descriptif" rows="3"></textarea>
                        </div>
                        
                        <input type="hidden" name="action" value="ajouter">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ajouter Chambre</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h2 class="card-title text-center mb-0">Liste des Chambres</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Prix</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($chambres && is_array($chambres)) : ?>
                                    <?php foreach ($chambres as $chambre) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($chambre['ID_Chambres']); ?></td>
                                            <td><?= htmlspecialchars($chambre['Type_Chambre']); ?></td>
                                            <td><?= htmlspecialchars($chambre['Prix']); ?> €</td>
                                            <td>
                                                <?php if (isset($chambre['Images']) && $chambre['Images']) : ?>
                                                    <img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']); ?>" 
                                                         alt="Photo de chambre" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 100px; max-height: 100px;">
                                                <?php else: ?>
                                                    <span class="text-muted">Pas d'image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <form action="/ppe/Controller/ChambreController.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $chambre['ID_Chambres']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Aucune chambre trouvée</td>
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
<?php include('./Vue/Footer.php'); ?>