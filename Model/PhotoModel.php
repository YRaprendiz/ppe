<!-- PhotoModel.php -->
 <?php

class PhotoModel {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterPhoto($image, $description, $chambreId = null) {
        $req = $this->bdd->prepare("INSERT INTO Photos (Images, Description, ID_Chambre) VALUES (:image, :description, :id_chambre)");
        $req->bindParam(':image', $image, PDO::PARAM_LOB);
        $req->bindParam(':description', $description);
        $req->bindParam(':id_chambre', $chambreId, PDO::PARAM_INT);
        return $req->execute();
    }

    public function modifierPhoto($id, $description, $chambreId = null) {
        $sql = "UPDATE Photos SET Description = :description";
        if ($chambreId !== null) {
            $sql .= ", ID_Chambre = :id_chambre";
        }
        $sql .= " WHERE ID_Photos = :id";
        
        $req = $this->bdd->prepare($sql);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':description', $description);
        if ($chambreId !== null) {
            $req->bindParam(':id_chambre', $chambreId, PDO::PARAM_INT);
        }
        return $req->execute();
    }

    public function supprimerPhoto($id) {
        $req = $this->bdd->prepare("DELETE FROM Photos WHERE ID_Photos = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        return $req->execute();
    }

    public function getPhotos() {
        $req = $this->bdd->prepare("
            SELECT p.*, c.Type_Chambre 
            FROM Photos p 
            LEFT JOIN Chambres c ON p.ID_Chambre = c.ID_Chambres
            ORDER BY p.ID_Photos DESC
        ");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPhotosByChambre($chambreId) {
        $req = $this->bdd->prepare("
            SELECT p.*, c.Type_Chambre 
            FROM Photos p 
            LEFT JOIN Chambres c ON p.ID_Chambre = c.ID_Chambres
            WHERE p.ID_Chambre = :id_chambre
            ORDER BY p.ID_Photos DESC
        ");
        $req->bindParam(':id_chambre', $chambreId, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
