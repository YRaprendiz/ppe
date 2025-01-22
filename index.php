<!-- index.php              -->
<?php
session_start();

include('Vue/Navbar.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
	case 'login':
			include('Vue/UserLogin.php');
		break;
	case 'inscription':
			include('Vue/UserInscription.php');
		break;
	case 'profil':
			include('Vue/UserProfil.php');
		break;
	case 'deconnexion':
		session_destroy();
		header('Location:http://127.0.0.1/ppe/');
		exit();
		break;

	case 'photos':
		include('Vue/PhotoForm.php');
		break;

	case 'chambresView':
		include('./Vue/ChambresView.php');
		break;
	case 'ajouterChambre':
		include('Vue/ChambreForm.php');
		break;

	case 'ModifierChambre':
		include('./Vue/ModifierChambreView.php');
		break;
	case 'ReserverChambre':
			include('./Vue/ReserverChambreView.php');
			break;

	case '404':
			include('404.php');
			break;

	case 'reservations':
		include('Controller/ChambreController.php');
		$controller = new ChambreController($bdd); // Instanciez le contrôleur
		include('Vue/ReservationList.php'); // Chargez la vue des réservations
		break;
	
	default:
			include('Vue/accueil.php');
		break;
}
include('Vue/footer.php');

?>