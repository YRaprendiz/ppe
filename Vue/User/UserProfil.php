<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: /ppe/Vue/Auth/AuthLogin.php');
    exit();
}

require_once(__DIR__ . '/../../Bdd/bdd.php');
require_once(__DIR__ . '/../../Model/UserModel.php');
require_once(__DIR__ . '/../../Model/ReservationModel.php');

$userModel = new UserModel($bdd);
$reservationModel = new ReservationModel($bdd);

$user = $userModel->getUserById($_SESSION['user']['ID_Utilisateur']);
$reservations = $reservationModel->getReservationsByUser($_SESSION['user']['ID_Utilisateur']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mon Profil</title>
    <style>
        .profile-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #007bff;
        }
    </style>
</head>
<body>
<?php include('/xampp/htdocs/ppe/Vue/Header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h3 mb-0 text-center">Mon Profil</h1>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($_GET['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($user): ?>
                            <div class="text-center mb-4">
                                <?php if (!empty($user['Images'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($user['Images']); ?>" 
                                         alt="Profile Picture" class="profile-image mb-3">
                                <?php else: ?>
                                    <div class="alert alert-info mb-3">Pas de photo de profil</div>
                                <?php endif; ?>

                                <h2 class="h4 mb-2"><?php echo htmlspecialchars($user['Prenom'] . ' ' . $user['Nom']); ?></h2>
                                <p class="text-muted mb-4"><?php echo htmlspecialchars($user['Email']); ?></p>
                                <p class="badge bg-secondary">Rôle: <?php echo htmlspecialchars($user['User_role']); ?></p>
                            </div>

                            <!-- Dropdown form to update name -->
                            <div class="dropdown mb-4">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonName" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mettre à jour le nom
                                </button>
                                <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButtonName">
                                    <li>
                                        <form action="/ppe/Controller/UserController.php" method="post">
                                            <input type="hidden" name="action" value="updateName">
                                            <div class="mb-3">
                                                <label for="prenom" class="form-label">Prénom</label>
                                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['Prenom']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['Nom']) ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Mettre à jour le nom</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <!-- Dropdown form to update email -->
                            <div class="dropdown mb-4">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonEmail" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mettre à jour l'email
                                </button>
                                <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButtonEmail">
                                    <li>
                                        <form action="/ppe/Controller/UserController.php" method="post">
                                            <input type="hidden" name="action" value="updateEmail">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Mettre à jour l'email</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <!-- Dropdown form to update password -->
                            <div class="dropdown mb-4">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonPassword" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mettre à jour le mot de passe
                                </button>
                                <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButtonPassword">
                                    <li>
                                        <form action="/ppe/Controller/UserController.php" method="post">
                                            <input type="hidden" name="action" value="updatePassword">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir modifier votre mot de passe ?')">Mettre à jour le mot de passe</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <!-- Dropdown form to update profile image -->
                            <div class="dropdown mb-4">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonImage" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mettre à jour la photo de profil
                                </button>
                                <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButtonImage">
                                    <li>
                                        <form action="/ppe/Controller/UserController.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="updateProfileImage">
                                            <div class="mb-3">
                                                <label for="profileImage" class="form-label">Photo de profil</label>
                                                <input type="file" class="form-control" id="profileImage" name="profileImage" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Mettre à jour la photo de profil</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <!-- Dropdown form to update all information -->
                            <div class="dropdown mb-4">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonAll" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mettre à jour toutes les informations
                                </button>
                                <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButtonAll">
                                    <li>
                                        <form action="/ppe/Controller/UserController.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="updateAll">
                                            <div class="mb-3">
                                                <label for="prenom" class="form-label">Prénom</label>
                                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['Prenom']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['Nom']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                            </div>
                                            <div class="mb-3">
                                                <label for="profileImage" class="form-label">Photo de profil</label>
                                                <input type="file" class="form-control" id="profileImage" name="profileImage">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Mettre à jour toutes les informations</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <h3 class="mt-5">Mes Réservations</h3>
                            <?php if (!empty($reservations)): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Chambre</th>
                                                <th>Date d'arrivée</th>
                                                <th>Date de départ</th>
                                                <th>Prix Total</th>
                                                <th>Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reservations as $reservation): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($reservation['ID_Reservation']) ?></td>
                                                    <td><?= htmlspecialchars($reservation['ID_Chambres']) ?></td>
                                                    <td><?= htmlspecialchars($reservation['Date_Debut']) ?></td>
                                                    <td><?= htmlspecialchars($reservation['Date_Fin']) ?></td>
                                                    <td><?= htmlspecialchars($reservation['Prix_Total']) ?> €</td>
                                                    <td><?= htmlspecialchars($reservation['Statut_Reservation']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted">Aucune réservation trouvée</p>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning text-center" role="alert">
                                Utilisateur non trouvé
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/ppe/index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">

<?php include '/xampp/htdocs/ppe/Vue/Footer.php';?>
</body>
</html>