<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php include 'VueNavbar.php'; renderNavbar(); ?>
    <div class="container my-5">
        <h1 class="text-center">Bienvenue sur notre Hôtel</h1>
        <p class="text-center">Nous vous offrons des chambres confortables et un service exceptionnel. Découvrez nos chambres disponibles et réservez dès aujourd'hui !</p>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="images/hotel_lobby.jpg" class="card-img-top" alt="Hall d'entrée">
                    <div class="card-body">
                        <h5 class="card-title">Explorez notre Hôtel</h5>
                        <p class="card-text">L'hôtel propose une large gamme de chambres adaptées à tous vos besoins. Venez découvrir notre établissement moderne et confortable.</p>
                        <a href="index.php?page=chambres" class="btn btn-primary">Voir nos chambres</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <img src="images/services.jpg" class="card-img-top" alt="Nos services">
                    <div class="card-body">
                        <h5 class="card-title">Nos Services</h5>
                        <p class="card-text">Profitez de nos services premium : Wi-Fi gratuit, salle de sport, restaurant et bien plus encore. Nous nous engageons à rendre votre séjour agréable.</p>
                        <a href="index.php?page=contact" class="btn btn-primary">Contactez-nous</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
