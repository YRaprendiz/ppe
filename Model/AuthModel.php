<?php
class AuthModel
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Verifica se o email já está registrado
    public function isEmailTaken($email)
    {
        $stmt = $this->bdd->prepare('SELECT COUNT(*) FROM Utilisateurs WHERE Email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result > 0; // Retorna true se o email já estiver registrado
    }
    

    public function addUser($nom, $prenom, $email, $password, $image = null)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $req = $this->bdd->prepare("INSERT INTO utilisateurs (Nom, Prenom, Email, Mdp, Images) VALUES (:nom, :prenom, :email, :mdp, :image)");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $hashPassword);
        $req->bindParam(':image', $image, PDO::PARAM_LOB);

        return $req->execute();
    }

    public function checkLogin($email, $password)
    {
        $req = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE Email = :email");
        $req->bindParam(':email', $email);
        $req->execute();
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Mdp'])) {
            unset($user['Mdp']);
            return $user;
        }
        return false;
    }
}
