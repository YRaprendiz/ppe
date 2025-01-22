<!-- Model/UserModel.php          -->
<?php 
class Utilisateur
{
	
	function __construct($bdd)
	{
		$this->bdd = $bdd;
	}


	public function ajouterUtilisateur($nom, $prenom, $email, $mdp)
	{

		$hashPassword = sha1($mdp);
		$req = $this->bdd->prepare("INSERT INTO utilisateurs (Nom, Prenom, Email, Mdp) VALUES (:nom, :prenom, :email, :mdp)");
		$req->bindParam(':nom', $nom);
		$req->bindParam(':prenom', $prenom);
		$req->bindParam(':email', $email);
		$req->bindParam(':mdp', $hashPassword);

		return $req->execute();
	}

	public function checkLogin($email, $password)
	{

		$hashMdp = sha1($password);
		$req = $this->bdd->prepare("SELECT * FROM utilisateurs where Email =
			:email AND Mdp = :mdp");

		$req->bindParam(':email', $email);
		$req->bindParam(':mdp', $hashMdp);

		$req->execute();

		return $req->fetch();

	}

	public function getUtilisateurById($id) {
        $stmt = $this->bdd->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
	public function getAllUsers()
    {
        $req = $this->bdd->query("SELECT * FROM Utilisateurs");
        return $req->fetchAll();
    }
	////
	public function updateUtilisateur($id, $nom, $prenom, $email, $mdp = null)
	{
    if ($mdp) {
        $hashPassword = password_hash($mdp, PASSWORD_BCRYPT);
        $sql = "UPDATE Utilisateurs SET Nom = :nom, Prenom = :prenom, Email = :email, Mdp = :mdp WHERE ID_Utilisateur = :id";
    } else {
        $sql = "UPDATE Utilisateurs SET Nom = :nom, Prenom = :prenom, Email = :email WHERE ID_Utilisateur = :id";
    }

    $req = $this->bdd->prepare($sql);
    $req->bindParam(':id', $id);
    $req->bindParam(':nom', $nom);
    $req->bindParam(':prenom', $prenom);
    $req->bindParam(':email', $email);
    if ($mdp) {
        $req->bindParam(':mdp', $hashPassword);
    }

    return $req->execute();
}


	

}
?>