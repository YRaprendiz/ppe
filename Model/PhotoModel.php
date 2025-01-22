<!-- PhotoModel.php -->
 <?php

class PhotoModel {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterPhoto($image, $description) {
        $req = $this->bdd->prepare("INSERT INTO Photos (Images, Description) VALUES (:image, :description)");
        $req->bindParam(':image', $image, PDO::PARAM_LOB);
        $req->bindParam(':description', $description);
        return $req->execute();
    }

    public function modifierPhoto($id, $description) {
        $req = $this->bdd->prepare("UPDATE Photos SET Description = :description WHERE ID_Photos = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':description', $description);
        return $req->execute();
    }

    public function supprimerPhoto($id) {
        $req = $this->bdd->prepare("DELETE FROM Photos WHERE ID_Photos = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        return $req->execute();
    }

    public function getPhotos() {
        $req = $this->bdd->prepare("SELECT * FROM Photos");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
