<?php
require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/AuthModel.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {session_start();}

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
            header('Location: /ppe/index.php?page=404&error=invalid_action');
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

                // Verificar se o email já está registrado
            if ($this->authModel->isEmailTaken($_POST['email'])) {
                header('Location: /ppe/index.php?page=authInscription&error=email_exists');
                exit();
            }

            $image = null;
            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
                $maxFileSize = 5 * 1024 * 1024;
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if ($_FILES['profileImage']['size'] <= $maxFileSize && in_array($_FILES['profileImage']['type'], $allowedTypes)) {
                    $image = file_get_contents($_FILES['profileImage']['tmp_name']);
                }
            }

            $success = $this->authModel->addUser(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                $_POST['password'],
                $image
            );

            if ($success) {
                $user = $this->authModel->checkLogin($_POST['email'], $_POST['password']);
                if ($user) {
                    $_SESSION['user'] = $user;
                }
                header('Location: /ppe/index.php?page=userProfil&success=registration_completed');
                exit();
            } else {
                header('Location: /ppe/index.php?page=authInscription&error=registration_failed');
                exit();
            }
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            header('Location: /ppe/index.php??page=authInscription&error=system');
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear all session data
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        header('Location: /ppe/index.php?page=authLogin');
        exit();
    }
}
