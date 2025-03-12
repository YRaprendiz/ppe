<!-- Vue/UserLogin.php          -->
<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to index
if (isset($_SESSION['user'])) {
    header('Location: /ppe/index.php');
    exit();
}

// Error messages
$error_messages = [
    'missing_fields' => 'Veuillez remplir tous les champs',
    'invalid_credentials' => 'Email ou mot de passe incorrect. Pas encore inscrit? Créez un compte pour se conecter e fair unne reservation',
    'system' => 'Une erreur système est survenue'
];
?>
<?php include('./Vue/header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">Login</h1>
                
                <?php if (isset($_GET['error']) && isset($error_messages[$_GET['error']])): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error_messages[$_GET['error']]); ?>
                    </div>
                <?php endif; ?>

                <form action="/ppe/Controller/AuthController.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <input type="hidden" name="action" value="login">
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                    <p class="text-center">Pas encore inscrit? <a href="/ppe/index.php?page=authInscription" class="btn btn-primary btn-block">Créez un compte ici</a></p>
                </form>
            </div>
        </div>
    </div>
<?php include('./Vue/footer.php'); ?>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ppe"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from Utilisateurs table
$sql = "SELECT ID_Utilisateur, Nom, Prenom, Email, User_role FROM Utilisateurs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="container mt-5">';
    echo '<h2 class="text-center">Liste des Utilisateurs</h2>';
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Rôle</th></tr></thead>';
    echo '<tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["ID_Utilisateur"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["Nom"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["Prenom"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["Email"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["User_role"]) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo "0 results";
}

$conn->close();
?>