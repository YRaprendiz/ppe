<!-- index.php              -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//include('Vue/Navbar.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
// VuePublic
    case '404':
        include('404.php');
        break;
    case 'accueil':
        include('./Vue/Accueil.php');
        break;
    case 'header':
        include('./Vue/header.php');
        break;
    case 'footer':
        include('./Vue/Vue/footer.php');
        break;
// Vue/Admin
    case 'adminChambreForm':
        include('./Vue/Admin/AdminChambreForm.php');
        break;
    case 'adminEditProfile':
        include('./Vue/Admin/AdminEditProfile.php');
        break;
    case 'adminListUser':
        include('./Vue/Admin/AdminListUser.php');
        break;
    case 'adminPhotoForm':
        include('./Vue/Admin/AdminPhotoForm.php');
        break;
    case 'adminReservationForm':
        include('./Vue/Admin/AdminReservationForm.php');
        break;
// Vue/Auth
    case 'authInscription':
        include('./Vue/Auth/AuthInscription.php');
        break;
    case 'authLogin':
        include('./Vue/Auth/AuthLogin.php');
        break;
    case 'authLogout':
        include('./Vue/Auth/AuthLogout.php');
        break;
// Vue/User
    case 'userChambresList':
        include('./Vue/User/UserChambresList.php');
        break;
    case 'userPhotoList':
        include('./Vue/User/UserPhotoList.php');
        break;
    case 'userReservationList':
        include('./Vue/User/UserReservationList.php');
        break;
    case 'userProfil':
        include('./Vue/User/UserUserProfil.php');
        break;

    default:
        header('Location: C:\xampp\htdocs\ppe\Vue\Accueil.php');
        exit();
}

include('Vue/Footer.php');
?>