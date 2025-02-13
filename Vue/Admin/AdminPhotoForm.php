<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// Check if we're in edit mode
$photoAModifier = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    foreach ($photos as $photo) {
        if ($photo['ID_Photos'] == $_GET['edit']) {
            $photoAModifier = $photo;
            break;
        }
    }
}
?>

<?php include('/xampp/htdocs/ppe/Vue/Header.php'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h1 class="card-title text-center mb-0">
                        <?= $photoAModifier ? 'Modifier une Photo' : 'Gestion des Photos' ?>
                    </h1>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['erreur'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['erreur']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <h2 class="h4 mb-3">
                        <?= $photoAModifier ? 'Modifier la Photo' : 'Ajouter une Photo' ?>
                    </h2>
                    <form action="/ppe/Controller/PhotoController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="<?= $photoAModifier ? 'modifier' : 'ajouter' ?>">
                        <?php if ($photoAModifier): ?>
                            <input type="hidden" name="id" value="<?= $photoAModifier['ID_Photos'] ?>">
                        <?php endif; ?>
                        
                        <?php if (!$photoAModifier): ?>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image :</label>
                                <input type="file" class="form-control" name="image" id="image" required>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description :</label>
                            <textarea class="form-control" name="description" id="description" rows="3" required><?= 
                                $photoAModifier ? htmlspecialchars($photoAModifier['Description']) : '' 
                            ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="id_chambre" class="form-label">Chambre :</label>
                            <select class="form-select" name="id_chambre" id="id_chambre">
                                <option value="">Sélectionnez une chambre</option>
                                <?php foreach ($chambres as $chambre): ?>
                                    <option value="<?= htmlspecialchars($chambre['ID_Chambres']); ?>"
                                        <?= $photoAModifier && $photoAModifier['ID_Chambre'] == $chambre['ID_Chambres'] ? 'selected' : '' ?>>
                                        Chambre <?= htmlspecialchars($chambre['ID_Chambres']); ?> 
                                        (<?= htmlspecialchars($chambre['Type_Chambre']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <?= $photoAModifier ? 'Modifier' : 'Ajouter' ?>
                            </button>
                            <?php if ($photoAModifier): ?>
                                <a href="/ppe/Vue/Admin/AdminPhotoForm.php" class="btn btn-secondary mt-2">Annuler</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h2 class="card-title text-center mb-0">Liste des Photos</h2>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php foreach ($photos as $photo): ?>
                            <div class="col">
                                <div class="card h-100">
                                    <img src="data:image/jpeg;base64,<?= base64_encode($photo['Photo']); ?>" 
                                         class="card-img-top" 
                                         alt="Photo" 
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">Description</h5>
                                        <p class="card-text"><?= htmlspecialchars($photo['Description']); ?></p>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <?= $photo['ID_Chambre'] ? 'Chambre ' . htmlspecialchars($photo['ID_Chambre']) . 
                                                    ' (' . htmlspecialchars($photo['Type_Chambre']) . ')' : 'Non assignée'; ?>
                                            </small>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="btn-group w-100" role="group">
                                            <a href="?edit=<?= $photo['ID_Photos'] ?>" class="btn btn-sm btn-warning">
                                                Modifier
                                            </a>
                                            <form action="/ppe/Controller/PhotoController.php" method="POST" class="d-inline w-100">
                                                <input type="hidden" name="action" value="supprimer">
                                                <input type="hidden" name="id" value="<?= $photo['ID_Photos']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger w-100" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($photos)): ?>
                            <div class="col-12">
                                <div class="alert alert-info text-center" role="alert">
                                    Aucune photo n'a été ajoutée
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('/xampp/htdocs/ppe/Vue/Footer.php'); ?>