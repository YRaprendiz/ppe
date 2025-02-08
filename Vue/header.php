<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Accueil - Hôtel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/ppe/assets/css/style.css">
</head>
<body>
    <div class="container my-5">
        <div class="text-center">
            <?php if (isset($_SESSION['user'])): ?>
                <h1>Bienvenu ! Vous êtes connecté comme <?php echo htmlspecialchars($_SESSION['user']['Email']); ?></h1>
            <?php else: ?>
                <h3>Bienvenu !</h3>
            <?php endif; ?>
        </div>

        <nav class="my-4">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item"><a class="nav-link" href="./index.php?page=accueil">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=chambresList">Chambres</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=photosList">Photos</a></li>

                <li class="nav-item"><a class="nav-link" href="./index.php?page=Login">Login</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="./index.php?page=reservations">Reservation</a></li>
                    <li class="nav-item"><a class="nav-link" href="./index.php?page=profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="./index.php?page=Exit">Exit</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>