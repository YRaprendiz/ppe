<?php
require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/AuthModel.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action'])) {
    $AuthController = new AuthController($bdd);

    switch ($_POST['action']) {
        case 'login':
            $AuthController->login();
            break;
        case 'logout':
            $AuthController->logout();
            break;
        case 'inscription':
            $AuthController->register();
            break;
        default:
            header('Location: /ppe/index.php?error=invalid_action');
            exit();
    }
}

class AuthController
{
    private $authModel;

    function __construct($bdd)
    {
        $this->authModel = new AuthModel($bdd);
    }

    public function register()
    {
        try {
            if (!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['password'])) {
                header('Location: /ppe/index.php?page=authInscription&error=missing_fields');
                exit();
            }

            $success = $this->authModel->addUser(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                $_POST['password']
            );

            if ($success) {
                header('Location: /ppe/index.php?page=userProfil&success=registration_completed');
                exit();
            } else {
                header('Location: /ppe/index.php?page=authInscription&error=registration_failed');
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
                header('Location: /ppe/index.php?page=authLogin&error=missing_fields');
                exit();
            }

            $user = $this->authModel->checkLogin($_POST['email'], $_POST['password']);
            
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: /ppe/index.php');
                exit();
            } else {
                error_log("Login failed for email: " . $_POST['email']);
                header('Location: /ppe/index.php?page=authLogin&error=invalid_credentials');
                exit();
            }
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            header('Location: /ppe/index.php?page=authLogin&error=system');
            exit();
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        
        header('Location: /ppe/index.php?page=accueil');
        exit();
    }
}
