<!--  ControllerUser.php -->
<?php
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
}

?>