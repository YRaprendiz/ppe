<!-- index.php              -->
<?php
session_start();
define('INCLUDED_FROM_INDEX', true);

include('Vue/Navbar.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Liste des pages accessibles sans connexion
$public_pages = [
    'accueil',
    'connexion',
    'inscription',
    'register',
    '404',
    'photosList',
    'chambresList'
];

// Liste des pages accessibles uniquement par les administrateurs
$admin_pages = [
    'utilisateurs',
    'photos',
    'chambres'
];

// Liste des pages accessibles par tous les utilisateurs connectés
$user_pages = [
    'profil',
    'editProfile'
];

// Liste des pages accessibles uniquement par les clients
$client_pages = [
    'reservations',
    'reservation'
];

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

if (in_array($page, $user_pages) && !isset($_SESSION['user'])) {
    header('Location: /ppe/index.php?page=connexion');
    exit();
}

switch ($page) {
    // Pages publiques
    case 'accueil':
        include('Vue/Accueil.php');
        break;
        
    case 'connexion':
        include('Vue/User/UserLogin.php');
        break;

    case 'inscription':
        include('Vue/User/UserInscription.php');
        break;

    case 'register':
        include('Vue/User/UserRegister.php');
        break;

    case 'photosList':
        include('Vue/Photo/PhotoList.php');
        break;

    case 'chambresList':
        include('Vue/Chambre/ChambresList.php');
        break;

    // Pages administrateur
    case 'utilisateurs':
        include('Vue/User/listUsers.php');
        break;

    case 'photos':
        include('Vue/Photo/PhotoForm.php');
        break;

    case 'chambres':
        include('Vue/Chambre/ChambreForm.php');
        break;

    // Pages utilisateur
    case 'profil':
        include('Vue/User/UserProfil.php');
        break;

    case 'editProfile':
        include('Vue/User/EditProfile.php');
        break;

    // Pages client
    case 'reservations':
        include('Vue/Reservation/ReservationList.php');
        break;

    case 'reservation':
        include('Vue/Reservation/ReservationForm.php');
        break;

    // Déconnexion
    case 'deconnexion':
        session_destroy();
        header('Location: /ppe/');
        exit();
        break;

    // Page d'erreur
    case '404':
        include('404.php');
        break;

    default:
        header('Location: /ppe/index.php?page=404');
        exit();
}

include('Vue/Footer.php');
?>