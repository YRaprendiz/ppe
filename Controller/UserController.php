<!-- Controller/UserController.php     -->
<?php
require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/UserModel.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action'])) {
	$UserController = new UserController($bdd);

	switch ($_POST['action']) {
		case 'login':
			$UserController->login();
			break;
		case 'logout':
			$UserController->logout();
			break;
		case 'listUsers':
			$UserController->listUsers();
			break;
		case 'inscription':
			$UserController->create();
			break;
		case 'getProfile':
			$UserController->getProfile();
			break;
		case 'updateProfile':
			$UserController->updateProfile();
			break;
		case 'adminUpdateUser':
			$UserController->adminUpdateUser();
			break;
		default:
			header('Location: /ppe/index.php?error=invalid_action');
			exit();
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
		try {
			if (!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['password'])) {
				header('Location: /ppe/Vue/User/UserRegister.php?error=missing_fields');
				exit();
			}

			$success = $this->userModel->addUser(
				$_POST['nom'],
				$_POST['prenom'],
				$_POST['email'],
				$_POST['password']
			);

			if ($success) {
				header('Location: /ppe/index.php?page=userProfil&success=registration_completed');
				exit();
			} else {
				header('Location: /ppe/Vue/User/UserRegister.php?error=registration_failed');
				exit();
			}
		} catch (Exception $e) {
			error_log("Registration error: " . $e->getMessage());
			header('Location: /ppe/index.php?page=404&error=system');
			exit();
		}
	}


	public function login()
	{
		try {
			if (!isset($_POST['email']) || !isset($_POST['password'])) {
				header('Location: /ppe/Vue/User/UserLogin.php?error=missing_fields');
				exit();
			}

			$user = $this->userModel->checkLogin($_POST['email'], $_POST['password']);
			
			if ($user) {
				$_SESSION['user'] = $user;
				header('Location: /ppe/index.php');
				exit();
			} else {
				// Log the failed attempt
				error_log("Login failed for email: " . $_POST['email']);
				header('Location: /ppe/Vue/User/UserLogin.php?error=invalid_credentials');
				exit();
			}
		} catch (Exception $e) {
			error_log("Login error: " . $e->getMessage());
			header('Location: /ppe/Vue/User/UserLogin.php?error=system');
			exit();
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

	public function logout()
	{
		// Destroy the session
		session_start();
		session_unset();
		session_destroy();
		
		// Redirect to login page
		header('Location: /ppe/index.php?page=accueil');
		exit();
	}

	public function updateProfile()
	{
		try {
			if (!isset($_SESSION['user'])) {
				header('Location: /ppe/Vue/User/UserLogin.php');
				exit();
			}

			$id = $_SESSION['user']['ID_Utilisateur'];
			$nom = $_POST['nom'] ?? null;
			$prenom = $_POST['prenom'] ?? null;
			$email = $_POST['email'] ?? null;
			$password = !empty($_POST['password']) ? $_POST['password'] : null;

			// Handle image upload
			$image = null;
			if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
				$maxFileSize = 5 * 1024 * 1024; // 5MB
				$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

				if ($_FILES['profile_image']['size'] > $maxFileSize) {
					header('Location: /ppe/Vue/User/UserProfil.php?error=file_too_large');
					exit();
				}

				if (!in_array($_FILES['profile_image']['type'], $allowedTypes)) {
					header('Location: /ppe/Vue/User/UserProfil.php?error=invalid_file_type');
					exit();
				}

				$image = file_get_contents($_FILES['profile_image']['tmp_name']);
			}

			if (!$nom || !$prenom || !$email) {
				header('Location: /ppe/Vue/User/UserProfil.php?error=missing_fields');
				exit();
			}

			$success = $this->userModel->updateUser($id, $nom, $prenom, $email, $password, $image);
			
			if ($success) {
				// Update session data
				$_SESSION['user'] = $this->userModel->getUserById($id);
				header('Location: /ppe/Vue/User/UserProfil.php?success=profile_updated');
			} else {
				header('Location: /ppe/Vue/User/UserProfil.php?error=update_failed');
			}
			exit();
		} catch (Exception $e) {
			error_log("Profile update error: " . $e->getMessage());
			header('Location: /ppe/Vue/User/UserProfil.php?error=system');
			exit();
		}
	}

public function adminUpdateUser()
{
    try {
        if (!isset($_SESSION['user']) || $_SESSION['user']['User_role'] !== 'Admin') {
            header('Location: /ppe/Vue/User/UserLogin.php');
            exit();
        }

        $id = $_POST['id'] ?? null;
        $nom = $_POST['nom'] ?? null;
        $prenom = $_POST['prenom'] ?? null;
        $email = $_POST['email'] ?? null;
        $user_role = $_POST['user_role'] ?? null;
        $password = !empty($_POST['password']) ? $_POST['password'] : null;

        if (!$id || !$nom || !$prenom || !$email || !$user_role) {
            header('Location: /ppe/Vue/Admin/AdminEditUser.php?id=' . $id . '&error=missing_fields');
            exit();
        }

        $success = $this->userModel->adminUpdateUser($id, $nom, $prenom, $email, $user_role, $password);
        
        if ($success) {
            header('Location: /ppe/Vue/Admin/AdminListUsers.php?success=user_updated');
        } else {
            header('Location: /ppe/Vue/Admin/AdminEditUser.php?id=' . $id . '&error=update_failed');
        }
        exit();
    } catch (Exception $e) {
        error_log("Admin user update error: " . $e->getMessage());
        header('Location: /ppe/Vue/Admin/AdminListUsers.php?error=system');
        exit();
    }
}
	}
