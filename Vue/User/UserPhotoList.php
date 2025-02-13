<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/PhotoModel.php');

try {
    $photoModel = new PhotoModel($bdd);
    $photos = $photoModel->getPhotos();

    // Check admin status
    $isAdmin = isset($_SESSION['user']) && isset($_SESSION['user']['User_role']) && $_SESSION['user']['User_role'] === 'admin';
} catch (Exception $e) {
    error_log("Error loading photos: " . $e->getMessage());
    $error = "Une erreur est survenue lors du chargement des photos.";
    $photos = [];
}
?>
<?php include('./Vue/header.php'); ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Galerie Photos</h1>
        <?php if ($isAdmin): ?>
            <a href="/ppe/index.php?page=photoForm" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajouter une photo
            </a>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) || isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars(isset($error) ? $error : $_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach ($photos as $photo): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="data:image/jpeg;base64,<?= base64_encode($photo['Photo']) ?>"
                         class="card-img-top"
                         alt="Photo de chambre"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($photo['Description']); ?></p>
                        <?php if ($photo['ID_Chambre']): ?>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="bi bi-door-closed"></i>
                                    Chambre <?= htmlspecialchars($photo['ID_Chambre']); ?>

                                </small>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php if ($isAdmin): ?>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="/ppe/index.php?page=photoForm&id=<?= $photo['ID_Photo'] ?>" 
                                   class="btn btn-outline-primary flex-grow-1">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form action="/ppe/Controller/PhotoController.php" method="POST" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?');"
                                      class="flex-grow-1">
                                    <input type="hidden" name="action" value="deletePhoto">
                                    <input type="hidden" name="id" value="<?= $photo['ID_Photo'] ?>">
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($photos)): ?>
        <div class="text-center py-5">
            <i class="bi bi-images display-1 text-muted mb-3"></i>
            <h3 class="text-muted">Aucune photo disponible</h3>
            <?php if ($isAdmin): ?>
                <p class="text-muted mb-4">Commencez par ajouter des photos à la galerie</p>
                <a href="/ppe/index.php?page=photoForm" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter une photo
                </a>
            <?php else: ?>
                <p class="text-muted">Veuillez revenir plus tard</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php include '/xampp/htdocs/ppe/Vue/Footer.php';?>