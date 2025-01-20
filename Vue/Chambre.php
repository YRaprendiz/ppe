<!--  VueChambre.php -->
  <?php
include('../Controller/Chambre.php');
include 'VueNavbar.php';
$controller = new ChambreController();
$chambres = $controller->list();
?>
<body>
    <div class="container my-5">
        <h1 class="text-center">Liste des Chambres</h1>
        <div class="row">
            <?php if (!empty($chambres)): ?>
                <?php foreach ($chambres as $chambre): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($chambre['image'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($chambre['image']) ?>" class="card-img-top" alt="Image Chambre">
                            <?php else: ?>
                                <img src="./images/hotel_lobby.jpg" class="card-img-top" alt="Image par défaut">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($chambre['chambre_type']) ?></h5>
                                <p class="card-text">Chambre N# <?= htmlspecialchars($chambre['chambres_number']) ?></p>
                                <p class="card-text">Prix par nuit : <?= htmlspecialchars($chambre['prix']) ?> €</p>
                                <p class="card-text"> Description Services : <?= htmlspecialchars($chambre['description']) ?> </p>
                            <div><p><a href="VueChambreDetails.php?id=<?= $chambre['id_chambre'] ?>" class="btn btn-primary">Voir détails</a> Loguin pour reserver!!</p></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-danger">Aucune chambre disponible , essaier de se connecter pour voir la liste complete de chambres.</p>
            <?php endif; ?>
        </div>
        <p><a href="VueAdminChambreAjouter.php">addchambre</a> Connectez-vous en tant qu'administrateur pour pouvoir ajouter des chambres d'hôtel</p>
    
    </div>
<?php
renderFooter();
?>