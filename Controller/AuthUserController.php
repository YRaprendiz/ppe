<?php
include './Bdd/bdd.php';
require_once './Model/AuthModel.php';

class AuthUserController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function login($email, $password) {
        try {
            $user = $this->authModel->authenticateUser($email, $password);
            if ($user) {
                // Start session and store user data
                session_start();
                $_SESSION['user'] = $user;
                return true;
            }
            return false;
        } catch (Exception $e) {
            // Log error
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    public function logout() {
        // Destroy session
        session_start();
        session_unset();
        session_destroy();

        // Redirect to login page
        header('Location: index.php?page=accueil');
        exit();
    }

    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['user']);
    }
    public function register($nom, $prenom, $email, $password) {
        try {
            return $this->authModel->registerUser($nom, $prenom, $email, $password);
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }


}