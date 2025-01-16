<!-- Index.php -->
<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
    case 'accueil':
        include 'VueAccueil.php';
        break;
    case 'admin':
            include 'VueAdmin.php';
            break;
    case 'profil':
        include 'VueProfil.php';
        break;
    case 'inscription':
        include 'VueInscription.php';
        break;
    case 'login':
        include 'VueLogin.php';
        break;
    case 'logout':
        include 'VueLogout.php';
        break;
    case 'chambres':
        include 'VueChambre.php';
        break;
    case 'ChambreDetails':
        include 'VueChambreDetails.php';
        break;
    

        
    default:
        include 'VueAccueil.php';
        break;
}
?>