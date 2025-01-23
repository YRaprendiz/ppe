<!-- Controller/UserController.php     -->
<?php
require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/UserModel.php');


if (isset($_POST['action'])) {
	$UserController = new UserController($bdd);

	switch ($_POST['action']) {
		case 'inscription':
			$UserController->create();
			break;
		case 'login':
			$UserController->login();
			break;
		case 'listUsers':
			$UserController->listUsers();
			break;
		case 'getProfile':
			$UserController->getProfile();
			break;
		case 'updateProfile':
			$UserController->updateProfile();
			break;
		default:
			# code...
			break;
	}
	
}

class UserController
{

	private $userModel;

	function __construct($bdd)
	{
		$this->userModel = new UserModel($bdd);
	}


	public function create()
	{
		$this->userModel->ajouterUtilisateur($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['password']);
		
		header('Location:http://127.0.0.1/ppe/');
	}


	public function login()
	{

	$user = $this->userModel->checkLogin($_POST['email'], $_POST['password']);
	
	if ($user) {
		session_start();
		$_SESSION['user'] = $user;

		header('Location: http://127.0.0.1/ppe/');
	}

	}
	
	public function listUsers()
    {
        return $this->userModel->getAllUsers();
    }
	////
	public function getProfile($id)
{
    return $this->userModel->getUtilisateurById($id);
}

public function updateProfile($id, $nom, $prenom, $email, $mdp = null)
{
    $this->userModel->updateUtilisateur($id, $nom, $prenom, $email, $mdp);
    header('Location: http://127.0.0.1/ppe/');
}
}


?>