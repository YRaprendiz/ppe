<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Détruire toutes les données de session
    session_unset();
    session_destroy();

    // Rediriger vers la page d'accueil ou une autre page
    header('Location: index.php');
    exit;
} else {
    // Si l'utilisateur n'est pas connecté, rediriger directement
    header('Location: index.php=?inscription');
    exit;
}
?>
