<?php
// Vérification si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Suppression des données de session
    session_unset(); // Vide les variables de session
    session_destroy(); // Détruit la session

    // Redirection vers la page d'accueil ou une page de connexion
    header("Location: index.php?page=login");
    exit(); // Termine le script après la redirection
} else {
    // Si aucun utilisateur n'est connecté, redirige directement
    header("Location: index.php");
    exit();
}
?>
