<?php

include('C:\xampp\htdocs\ppe\Controller\PhotoController.php');

// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create PhotoController instance
$photoController = new PhotoController();
$photos = $photoController->getPhotos();
$photo4 = $photos['photo4'];
$photo5 = $photos['photo5'];

?>
<?php include('header.php'); ?>
    <div class="container my-5">
        <div class="text-center">
            <?php if (isset($_SESSION['user'])): ?>
                <h1 style color="blue">Bienvenu ! Vous êtes connecté comme <?php echo htmlspecialchars($_SESSION['user']['Email']); ?></h1>
            <?php else: ?>
                <h3>Bienvenu !</h3>
            <?php endif; ?>
        </div>
    </div>

    <div class="container my-4">
        <h1 class="text-center">Bienvenue sur notre Hôtel</h1>
        <p class="text-center">Nous vous offrons des chambres confortables et un service exceptionnel. Découvrez nos chambres disponibles et réservez dès aujourd'hui !</p>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Explorez notre Hôtel</h5>
                        <p class="card-text">L'hôtel propose une large gamme de chambres adaptées à tous vos besoins. Venez découvrir notre établissement moderne et confortable.</p>
                        <a href="index.php?page=chambres" class="btn btn-primary">Voir nos chambres</a>
                    </div>
                    <img src="data:image/jpeg;base64,<?php echo $photo4 ? base64_encode($photo4['Photo']) : ''; ?>" class="card-img-top" alt="Image de l'hôtel">
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <img src="data:image/jpeg;base64,<?php echo $photo5 ? base64_encode($photo5['Photo']) : ''; ?>" class="card-img-top" alt="Nos services">
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