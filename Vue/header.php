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


    <nav class="my-4">
        <ul class="nav nav-pills justify-content-center">
            <li class="nav-item"><a class="nav-link" href="../index.php?page=accueil">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="./index.php?page=userChambresList">Chambres</a></li>
            <li class="nav-item"><a class="nav-link" href="./index.php?page=userPhotoList">Photos</a></li>
            <?php if (!isset($_SESSION['user'])): ?>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=AuthLogin">Login</a></li>
                <?php endif; ?>
            <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=UserReservationList">Reservation</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=UserProfil">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=AuthLogout">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>