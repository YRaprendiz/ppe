<?php
require_once './Bdd/bdd.php';

class AuthModel {
    private $bdd;

    public function __construct() {
        global $bdd;
        $this->bdd = $bdd;
    }

    public function authenticateUser($email, $password) {
        try {
            $stmt = $this->bdd->prepare("SELECT * FROM Utilisateurs WHERE Email = :email LIMIT 1");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['Mdp'])) {
                // Remove sensitive data before returning
                unset($user['Mdp']);
                return $user;
            }
            return false;
        } catch(PDOException $e) {
            error_log("Authentication error: " . $e->getMessage());
            return false;
        }
    }

    public function registerUser($nom, $prenom, $email, $password, $role = 'Client') {
        try {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->bdd->prepare("INSERT INTO Utilisateurs (Nom, Prenom, Email, Mdp, User_role) VALUES (:nom, :prenom, :email, :password, :role)");
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);

            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }
}