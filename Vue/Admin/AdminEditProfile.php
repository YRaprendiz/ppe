<title>Mon Admin Profil</title>
<?php
include '../ppe/Vue/Header.php';
?>
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
$UserReservationModel = new UserReservationModel($bdd);

$user = $userModel->getUserById($_SESSION['user']['ID_Utilisateur']);
$reservations = $UserReservationModel->getReservationsByUser($_SESSION['user']['ID_Utilisateur']);
?>
    
<body>
<?php if ($_SESSION['user']['User_role'] == 'Admin'): ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h1 class="card-title text-center mb-0">Modifier mon Profil</h1>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="/ppe/Controller/UserController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="updateProfile">
                            
                            <div class="mb-3 text-center">
                                <?php if (!empty($user['Images'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($user['Images']); ?>" 
                                         alt="Profile Picture" class="img-thumbnail rounded-circle mb-3" 
                                         style="max-width: 200px; max-height: 200px;">
                                <?php else: ?>
                                    <div class="alert alert-info">Pas de photo de profil</div>
                                <?php endif; ?>
                                
                                <div class="mb-3">
                                    <label for="profile_image" class="form-label">Changer la photo de profil</label>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" 
                                           accept="image/jpeg,image/png,image/gif">
                                    <small class="form-text text-muted">Formats acceptés: JPEG, PNG, GIF (max 5MB)</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" 
                                       value="<?php echo htmlspecialchars($user['Nom']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" 
                                       value="<?php echo htmlspecialchars($user['Prenom']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="form-text text-muted">Laissez vide si vous ne voulez pas changer votre mot de passe</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                                <a href="/ppe/Vue/User/UserProfil.php" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<!-- Client et Null -->
<?php if ($_SESSION['user']['User_role'] == 'Client' && $_SESSION['user']['User_role'] !== null): ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-center mb-0">Erreur, connectez-vous en tant qu'administrateur pour accéder à cette page</h4>
                    </div>              
                            <div class="mb-3 text-center">
                                <?php if (!empty($user['Images'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($user['Images']); ?>" 
                                         alt="Profile Picture" class="img-thumbnail rounded-circle mb-3" 
                                         style="max-width: 200px; max-height: 200px;">
                                <?php else: ?>
                                    <div class="alert alert-info">Pas de photo de profil</div>
                                <?php endif; ?>
                            </div>
                    </div>                
                </div> 
            </div> 
        </div> 
    </div> 
<?php endif; ?>