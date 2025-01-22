<!-- index.php              -->
<?php
session_start();

include('Vue/Navbar.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
	case 'login':
			include('Vue/User/UserLogin.php');
		break;
	case 'inscription':
			include('Vue/User/UserInscription.php');
		break;
	case 'listUsers':
		include('Vue/User/listUsers.php');
		break;
	case 'profil':
			include('Vue/User/UserProfil.php');
		break;
	case 'deconnexion':
		session_destroy();
		header('Location:http://127.0.0.1/ppe/');
		exit();
		break;

	case 'photos':
		include('Vue/Photo/PhotoForm.php');
		break;
	case 'photosList':
		include('Vue/Photo/PhotoList.php');
		break;
		
	case 'chambreForm':
		include('Vue/Chambre/ChambreForm.php');
		break;
	case 'chambresList':
		include('./Vue/Chambre/ChambresList.php');
		break;

	case 'reserverChambre':
			include('./Vue/ReserverChambreView.php');
			break;

	case '404':
			include('404.php');
			break;
	
	default:
			include('Vue/accueil.php');
		break;
}
include('Vue/footer.php');

?>