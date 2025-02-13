<!-- Model/UserModel.php          -->
<?php 
class UserModel
{
	
	private PDO $bdd;

	function __construct(PDO $bdd)
	{
		$this->bdd = $bdd;
	}

	public function getAllUsers()
    {
        $req = $this->bdd->query("SELECT * FROM Utilisateurs");
        return $req->fetchAll();
    }

	public function getUserById($id) {
        $stmt = $this->bdd->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

	public function updateUser($id, $nom, $prenom, $email, $password = null, $image = null)
	{
    $params = [
        ':id' => $id,
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email
    ];

    $sql = "UPDATE Utilisateurs SET Nom = :nom, Prenom = :prenom, Email = :email";

    if ($password) {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql .= ", Mdp = :mdp";
        $params[':mdp'] = $hashPassword;
    }

    if ($image !== null) {
        $sql .= ", Images = :image";
        $params[':image'] = $image;
    }

    $sql .= " WHERE ID_Utilisateur = :id";

    $req = $this->bdd->prepare($sql);
    return $req->execute($params);
}

public function adminUpdateUser($id, $nom, $prenom, $email, $user_role, $password = null)
{
	$params = [
		':id' => $id,
		':nom' => $nom,
		':prenom' => $prenom,
		':email' => $email,
		':user_role' => $user_role
	];

	$sql = "UPDATE Utilisateurs SET Nom = :nom, Prenom = :prenom, Email = :email, User_role = :user_role";

	if ($password) {
		$hashPassword = password_hash($password, PASSWORD_BCRYPT);
		$sql .= ", Mdp = :mdp";
		$params[':mdp'] = $hashPassword;
	}

	$sql .= " WHERE ID_Utilisateur = :id";

	$req = $this->bdd->prepare($sql);
	return $req->execute($params);
}

}
?>