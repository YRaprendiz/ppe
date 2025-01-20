<!-- Index.php -->
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';
switch ($page) {
    case 'accueil':
        include ('Accueil.php');
        break;
    case 'admin':
            include ('VueAdmin.php');
            break;
    case 'profil':
        include ('VueProfil.php');
        break;
    case 'inscription':
        include ('Inscription.php');
        break;
    case 'login':
        include ('Login.php');
        break;
    case 'logout':
        include ('Logout.php');
        break;
    case 'chambres':
        include ('Chambre.php');
        break;
    case 'ChambreDetails':
        include ('ChambreDetails.php');
        break;
    case 'contact':
        include ('Contact.php');
        break;
                
    default:
        include ('Accueil.php');
        break;
}
?>