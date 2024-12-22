<!--  ModelUser.php-->
<?php
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

}

?>