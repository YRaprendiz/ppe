<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Photos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<?php 
include './Vue/header.php';
try {
    $bdd = new PDO('mysql:host=localhost;dbname=ppe;charset=utf8', 'root', '', array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));
} catch(PDOException $e) {
    die('Erreur de Login : ' . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {session_start();}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (true) {
        case isset($_POST['custom_login']) && !empty($_POST['user_id']):
            $user_id = (int) $_POST['user_id'];
            $stmt = $bdd->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
            $_SESSION['user'] = $user;
            break;
        case isset($_POST['admin']):
            $stmt = $bdd->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = 1");
            $stmt->execute();
            $user = $stmt->fetch();
            $_SESSION['user'] = $user;
            break;
        case isset($_POST['client']):
            $stmt = $bdd->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = 2");
            $stmt->execute();
            $user = $stmt->fetch();
            $_SESSION['user'] = $user;
            break;
        case isset($_POST['logout']):
            session_unset();
            session_destroy();
            break;
    }
}
?>
    <!-- Login/Logout Test Form -->
    <div class="container mt-5 text-center">
        <form method="post">
            <div class="mb-3">
                <button type="submit" name="admin" class="btn btn-primary">1 - Admin</button>
                <button type="submit" name="client" class="btn btn-secondary">2 -Client</button>
                <button type="submit" name="logout" class="btn btn-danger">Se déconnecter</button>
            </div>
            <div class="mb-3">
                <input type="number" name="user_id" placeholder="ID utilisateur" class="form-control w-25 d-inline-block">
                <button type="submit" name="custom_login" class="btn btn-info">Se connecter par ID</button>
            </div>
        </form>

        <?php if (isset($_SESSION['user'])): ?>
            <p class="alert alert-success">Connecté en tant que : <?= $_SESSION['user']['Nom'] ?> <?= $_SESSION['user']['Prenom'] ?> (<?= $_SESSION['user']['User_role'] ?>)</p>
        <?php else: ?>
            <p class="alert alert-warning">Non connecté</p>
        <?php endif; ?>
    </div>

    <div class="container my-5">
        <!-- Welcome message if user is logged in -->
        <?php
            if (isset($_SESSION['user'])) {
                $nom = htmlspecialchars($_SESSION['user']['Nom']);
                $prenom = htmlspecialchars($_SESSION['user']['Prenom']);
                $email = htmlspecialchars($_SESSION['user']['Email']);

                echo "<div class='text-center'>
                        <h4>Bienvenue, $prenom $nom!</h4>
                        <p>Votre email est: $email</p>
                    </div>";
            }

            if (isset($_SESSION['user']) && !empty($_SESSION['user']['Images'])) {
                $imageData = base64_encode($_SESSION['user']['Images']);
                echo "<div class='text-center'>
                        <img src='data:image/jpeg;base64,$imageData' alt='User image' class='img-fluid rounded-circle' style='max-width:200px;'/>
                    </div>";
            }
        ?>
    <!-- Bootstrap JS (Optional for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>