<?php
// ModelUser.php - Modèle pour gérer les utilisateurs
class Utilisateur {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    // Ajouter un utilisateur
    public function ajouterUtilisateur($nom, $prenom, $email, $pass, $roles) {
        $hashPassword = password_hash($pass, PASSWORD_BCRYPT);
        $req = $this->bdd->prepare("INSERT INTO UTILISATEURS (nom, prenom, email, pass, roles) VALUES (:nom, :prenom, :email, :pass, :roles)");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':pass', $hashPassword);
        $req->bindParam(':roles', $roles);
        return $req->execute();
    }

    // Vérifier la connexion
    public function checkLogin($email, $password) {
        $req = $this->bdd->prepare("SELECT * FROM UTILISATEURS WHERE email = :email");
        $req->bindParam(':email', $email);
        $req->execute();
        $user = $req->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['pass'])) {
            return $user;
        }
        return false;
    }
    public function getAll() {
        $query = $this->bdd->query("SELECT * FROM UTILISATEURS");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!--  ModelUser.php

include('./bdd.php');
class ModelUser extends BaseModel {
    // Méthode pour enregistrer un utilisateur
    public function inscription($nom, $prenom, $email, $password, $telephone) {
        $stmt = $this->bdd->prepare("INSERT INTO UTILISATEURS (roles, nom, prenom, email, pass, telephone) VALUES ('client', :nom, :prenom, :email, :password, :telephone)");
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'telephone' => $telephone
        ]);
    }

    // Méthode pour récupérer un utilisateur par email
    public function getUserByEmail($email) {
        $stmt = $this->bdd->prepare("SELECT * FROM UTILISATEURS WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Méthode pour récupérer un utilisateur par ID
    public function getUserById($id) {
        $stmt = $this->bdd->prepare("SELECT * FROM UTILISATEURS WHERE id_user = :id_user");
        $stmt->execute(['id_user' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour mettre à jour les informations utilisateur
    public function updateUser($id, $nom, $prenom, $email, $telephone) {
        $stmt = $this->bdd->prepare("UPDATE UTILISATEURS SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone WHERE id_user = :id_user");
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'id_user' => $id
        ]);
    }
    //role 
    public function getRoleById($id) {
        $stmt = $this->bdd->prepare("SELECT roles FROM UTILISATEURS WHERE id_user = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['roles'] : null;
    }
    

}
-->