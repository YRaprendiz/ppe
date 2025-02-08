<!-- index.php              -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//include('Vue/Navbar.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
    // Pages publiques
    case 'accueil':
        require('Vue/Accueil.php');
        break;
        
    case 'Login':
        include('Vue/User/UserLogin.php');
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
    case 'chambreForm':
        include('Vue/Chambre/ChambreForm.php');
        break;

    case 'addChambre':
        include('Vue/Chambre/AddChambre.php');
        break;

    case 'photoForm':
        include('Vue/Photo/PhotoForm.php');
        break;

    case 'editProfile':
        include('Vue/User/EditProfile.php');
        break;

    case 'listUser':
        include('Vue/User/ListUser.php');
        break;

    case 'chambreDetails':
        include('Vue/Chambre/ChambreDetails.php');
        break;

    case 'photoGallery':
        include('Vue/Photo/PhotoGallery.php');
        break;

    case 'userSettings':
        include('Vue/User/UserSettings.php');
        break;

    case 'adminPanel':
        include('Vue/Admin/AdminPanel.php');
        break;

    case 'siteMap':
        include('Vue/SiteMap.php');
        break;

    // Pages utilisateur
    case 'profil':
        include('Vue/User/UserProfil.php');
        break;

    case 'modifierProfile':
        include('Vue/User/EditProfile.php');
        break;

    // Pages client
    case 'reservations':
        include('Vue/Reservation/ReservationList.php');
        break;

    case 'reservation':
        include('Vue/Reservation/ReservationForm.php');
        break;

    // DéLogin
    case 'Exit':
        session_destroy();
        header('Location: /ppe/');
        exit();
        break;
    case 'logout':
        include('Vue/User/UserLogout.php');
        break;
    //nav bar
    case 'header':
        include('Vue/header.php');
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