<!-- ControllerUser.php -->
<?php
// ControllerUser.php - Contrôleur pour gérer l'authentification
include('../Model/User.php');
//include('./Bdd/bdd.php');

if (isset($_POST['action'])) {
    $UtilisateurController = new UtilisateurController($bdd);
    switch ($_POST['action']) {
        case 'inscription':
            $UtilisateurController->create();
            break;
        case 'login':
            $UtilisateurController->login();
            break;
        default:
            echo "Action inconnue.";
            break;
    }
}

class UtilisateurController {
    private $utilisateur;

    public function __construct($bdd) {
        $this->utilisateur = new Utilisateur($bdd);
    }

    public function create() {
        $this->utilisateur->ajouterUtilisateur(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['password'],
            'client' // Rôle par défaut
        );
        header('Location: ./index.php');
    }

    public function login() {
        $user = $this->utilisateur->checkLogin($_POST['email'], $_POST['password']);
        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: index.php'); // Page d'accueil après connexion
        } else {
            header('Location: ./index.php');
        }
    }
    // Récupérer toutes les Users
    public function list() {
        $User = $this->utilisateur->getAll();
        return $User;
    }


}
?>

<!--  ControllerUser.php 
include('./ModelUser.php');

class ControllerUser {
    private $modelUser;

    public function __construct() {
        $this->modelUser = new ModelUser();
    }

    // Inscription d'un utilisateur
    public function inscriptionUser($nom, $prenom, $email, $password, $telephone) {
        if ($this->modelUser->getUserByEmail($email)) {
            FlashMessage::set('danger', 'Cet email est déjà utilisé.');
            return false;
        }
        $this->modelUser->inscription($nom, $prenom, $email, $password, $telephone);
        FlashMessage::set('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
        return true;
    }

    // Connexion d'un utilisateur
    public function loginUser($email, $password) {
        $user = $this->modelUser->getUserByEmail($email);
        if ($user && password_verify($password, $user['pass'])) {
            session_start();
            $_SESSION['user'] = $user;
            FlashMessage::set('success', 'Connexion réussie.');
            return true;
        } else {
            FlashMessage::set('danger', 'Email ou mot de passe incorrect.');
            return false;
        }
    }
    // Récupérer les informations utilisateur
    public function getUserById($id) {
        return $this->modelUser->getUserById($id);
    }

    // Mettre à jour les informations utilisateur
    public function updateUser($id, $nom, $prenom, $email, $telephone) {
        $this->modelUser->updateUser($id, $nom, $prenom, $email, $telephone);
        FlashMessage::set('success', 'Mise à jour réussie.');
    } 
    public function isAdmin($id_user) {
        $role = $this->model->getRoleById($id_user);
        return $role === 'admin';
    }

    public function adminPage() {
        if (isset($_SESSION['user_id']) && $this->isAdmin($_SESSION['user_id'])) {
            include('./VueAdmin.php');
        } else {
            header('Location: index.php'); // Redirection si non autorisé
            exit;
        }
    }
}
-->