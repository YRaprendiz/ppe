<!-- index.php              -->
<?php
session_start();
define('INCLUDED_FROM_INDEX', true);

include('Vue/Navbar.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Liste des pages accessibles sans connexion
$public_pages = ['accueil', 'connexion', 'inscription', '404', 'photosList', 'chambresList'];

// Liste des pages accessibles uniquement par les administrateurs
$admin_pages = ['utilisateurs', 'photos', 'chambres'];

// Liste des pages accessibles uniquement par les clients
$client_pages = ['reservations'];

// Vérification des autorisations
if (!in_array($page, $public_pages) && !isset($_SESSION['user'])) {
    header('Location: /ppe/index.php?page=404');
    exit();
}

if (in_array($page, $admin_pages) && (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin')) {
    header('Location: /ppe/index.php?page=404');
    exit();
}

if (in_array($page, $client_pages) && (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Client')) {
    header('Location: /ppe/index.php?page=404');
    exit();
}

switch ($page) {
    case 'accueil':
        include('Vue/accueil.php');
        break;
        
    case 'connexion':
        include('Vue/User/UserLogin.php');
        break;

    case 'inscription':
        include('Vue/User/UserInscription.php');
        break;

    case 'utilisateurs':
        include('Vue/User/listUsers.php');
        break;

    case 'profil':
        include('Vue/User/UserProfil.php');
        break;

    case 'chambres': // Admin management page
        include('Vue/Chambre/ChambreForm.php');
        break;

    case 'chambresList': // Public view page
        include('Vue/Chambre/ChambresList.php');
        break;

    case 'photos': // Admin management page
        include('Vue/Photo/PhotoForm.php');
        break;

    case 'photosList': // Public view page
        include('Vue/Photo/PhotoList.php');
        break;

    case 'reservations':
        include('Vue/Reservation/ReservationList.php');
        break;

    case 'deconnexion':
        session_destroy();
        header('Location: /ppe/');
        exit();
        break;

    case '404':
        include('404.php');
        break;

    default:
        header('Location: /ppe/index.php?page=404');
        exit();
}

include('Vue/footer.php');
?>