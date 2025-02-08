<?php
include('./Bdd/bdd.php');
require_once(__DIR__ . '/../Model/PhotoModel.php');

// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create PhotoModel instance
$photoModel = new PhotoModel($bdd);

// Retrieve specific photos
$photo4 = null;
$photo5 = null;

$photos = $photoModel->getPhotos();
foreach ($photos as $photo) {
    if ($photo['ID_Photos'] == 4) {
        $photo4 = $photo;
    }
    if ($photo['ID_Photos'] == 5) {
        $photo5 = $photo;
    }
}
?>
<?php include('header.php'); ?>

        <h1 class="text-center">Bienvenue sur notre Hôtel</h1>
        <p class="text-center">Nous vous offrons des chambres confortables et un service exceptionnel. Découvrez nos chambres disponibles et réservez dès aujourd'hui !</p>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="data:image/jpeg;base64,<?php echo $photo4 ? base64_encode($photo4['Images']) : ''; ?>" class="card-img-top" alt="Image de l'hôtel">
                    <div class="card-body">
                        <h5 class="card-title">Explorez notre Hôtel</h5>
                        <p class="card-text">L'hôtel propose une large gamme de chambres adaptées à tous vos besoins. Venez découvrir notre établissement moderne et confortable.</p>
                        <a href="index.php?page=chambres" class="btn btn-primary">Voir nos chambres</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <img src="data:image/jpeg;base64,<?php echo $photo5 ? base64_encode($photo5['Images']) : ''; ?>" class="card-img-top" alt="Nos services">
                    <div class="card-body">
                        <h5 class="card-title">Nos Services</h5>
                        <p class="card-text">Profitez de nos services premium : Wi-Fi gratuit, salle de sport, restaurant et bien plus encore. Nous nous engageons à rendre votre séjour agréable.</p>
                        <a href="index.php?page=contact" class="btn btn-primary">Contactez-nous</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include('footer.php'); ?>