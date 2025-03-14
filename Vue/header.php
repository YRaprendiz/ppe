<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Traitement du formulaire de connexion/déconnexion (logique reprise depuis test.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=ppe;charset=utf8', 'root', '', array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ));
    } catch(PDOException $e) {
        die('Erreur de connexion BD : ' . $e->getMessage());
    }

    if (isset($_POST['admin'])) {
        $stmt = $bdd->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = 1");
        $stmt->execute();
        $user = $stmt->fetch();
        $_SESSION['user'] = $user;
        header("Location: ./index.php");
        exit;
    } elseif (isset($_POST['client'])) {
        $stmt = $bdd->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = 2");
        $stmt->execute();
        $user = $stmt->fetch();
        $_SESSION['user'] = $user;
        header("Location: ./index.php");
        exit;
    } elseif (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: ./index.php");
        exit;
    }
}
?>
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
            <li class="nav-item"><a class="nav-link" href="/ppe/index.php">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="./index.php?page=userChambresList">Chambres</a></li>
            <li class="nav-item"><a class="nav-link" href="./index.php?page=userPhotoList">Photos</a></li>
            <li class="nav-item"><a class="nav-link" href="./index.php?page=userPhotoList">Contact</a></li>
            <?php if (!isset($_SESSION['user'])): ?>
                <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=test">Test 00</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=authLogin">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=authInscription">Inscription</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=test">Test 01</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=userMesReservationList">Mes Reservation</a></li>
                <li class="nav-item"><a class="nav-link" href="./index.php?page=userProfil">Profil</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=authLogout">Logout</a></li>
                <li class="nav-item">
                    <div class="nav-link d-flex align-items-center">
                        <?php if (isset($_SESSION['user']['Images']) && !empty($_SESSION['user']['Images'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($_SESSION['user']['Images']); ?>" 
                                 alt="Profile" class="rounded-circle me-2" 
                                 style="width: 30px; height: 30px; object-fit: cover;">
                        <?php endif; ?>
                        <span class="text-blue fw-bold">
                            <?php echo htmlspecialchars($_SESSION['user']['User_role']); ?> : <?php echo htmlspecialchars($_SESSION['user']['Email']); ?>
                        </span>
                            <!-- Formulaire de debug pour se connecter en tant qu'Admin (ID 1), Client (ID 2) ou par ID personnalisé -->
    <div class="container  mt-3"><form method="post">
                <button type="submit" name="admin" class="btn btn-primary">1-Admin</button>
                <button type="submit" name="client" class="btn btn-secondary">2-Client</button>
                <button type="submit" name="logout" class="btn btn-danger">Log</button>
        </form></div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['User_role'] === 'Admin'): ?>
                <ul class="nav nav-pills justify-content-center mt-3">
                    <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=adminChambreForm">Admin Chambre Form</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=adminPhotoForm">Admin Photo Form</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=adminReservationForm">Admin Reservation Form</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=adminEditProfile">Admin Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=adminListUser">Admin List User</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="./index.php?page=test">Test 00</a></li>
                </ul>
            <?php endif; ?>
        </ul>
    </nav>



</body>
</html>