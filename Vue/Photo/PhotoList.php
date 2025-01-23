<?php
require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/PhotoModel.php');

$photoModel = new PhotoModel($bdd);
$photos = $photoModel->getPhotos();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="text-center">Galerie Photos</h1>
            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['erreur'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['erreur']) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($photos as $photo): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="data:image/jpeg;base64,<?= base64_encode($photo['Images']); ?>" 
                         class="card-img-top img-fluid" 
                         alt="Photo de chambre"
                         style="object-fit: cover; height: 200px;">
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($photo['description']); ?></p>
                        <?php if ($photo['chambre_id']): ?>
                            <p class="card-text">
                                <small class="text-muted">
                                    Chambre <?= htmlspecialchars($photo['chambre_id']); ?>
                                    (<?= htmlspecialchars($photo['Type_Chambre']); ?>)
                                </small>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>