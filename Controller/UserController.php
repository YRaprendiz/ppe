<!-- Controller/UserController.php     -->
<?php
include('../Model/UserModel.php');
include('../Bdd/bdd.php');


if (isset($_POST['action'])) {
	$UtilisateurController = new UtilisateurController($bdd);

	switch ($_POST['action']) {
		case 'inscription':
			$UtilisateurController->create();
			break;
		case 'login':
			$UtilisateurController->login();
			break;
		case 'listUsers':
			$UtilisateurController->listUsers();
			break;
		case 'getProfile':
			$UtilisateurController->getProfile();
			break;
		case 'updateProfile':
			$UtilisateurController->updateProfile();
			break;
		default:
			# code...
			break;
	}
	
}

class UtilisateurController
{

	private $utilisateur;

	function __construct($bdd)
	{
		$this->utilisateur = new utilisateur($bdd);
	}


	public function create()
	{
		$this->utilisateur->ajouterUtilisateur(
			$_POST['nom'],
			 $_POST['prenom'],
			  $_POST['email'],
			   $_POST['password']
			);
		header('Location:http://127.0.0.1/ppe/');
	}


	public function login()
	{

	$user = $this->utilisateur->checkLogin($_POST['email'], $_POST['password']);

	
	if ($user) {
		session_start();
		$_SESSION['user'] = $user;

		header('Location: http://127.0.0.1/ppe/');
	}else {header('Location: http://127.0.0.1/ppe/404.php');}

	}
	
	public function listUsers()
    {
        return $this->utilisateur->getAllUsers();
    }
	////
	public function getProfile($id)
{
    return $this->utilisateur->getUtilisateurById($id);
}

public function updateProfile($id, $nom, $prenom, $email, $mdp = null)
{
    $this->utilisateur->updateUtilisateur($id, $nom, $prenom, $email, $mdp);
    header('Location: /ppe/profile.php?message=Profil mis à jour avec succès');
}
}


?>