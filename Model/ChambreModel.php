<!-- ChambreModel-->
 <?php

class ChambreModel {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterChambre($image, $chambreCode, $type, $prix, $descriptif) {
        $req = $this->bdd->prepare("
            INSERT INTO Chambres (Images, Chambre_000, Type_Chambre, Prix, Descriptif) 
            VALUES (:image, :chambreCode, :type, :prix, :descriptif)
        ");
        $req->bindParam(':image', $image, PDO::PARAM_LOB);
        $req->bindParam(':chambreCode', $chambreCode);
        $req->bindParam(':type', $type);
        $req->bindParam(':prix', $prix);
        $req->bindParam(':descriptif', $descriptif);
        return $req->execute();
    }

    public function modifierChambre($id, $type, $prix, $descriptif) {
        $req = $this->bdd->prepare("
            UPDATE Chambres 
            SET Type_Chambre = :type, Prix = :prix, Descriptif = :descriptif 
            WHERE ID_Chambres = :id
        ");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':type', $type);
        $req->bindParam(':prix', $prix);
        $req->bindParam(':descriptif', $descriptif);
        return $req->execute();
    }

    public function supprimerChambre($id) {
        $req = $this->bdd->prepare("DELETE FROM Chambres WHERE ID_Chambres = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        return $req->execute();
    }

    public function getChambres() {
        $req = $this->bdd->prepare("SELECT * FROM Chambres");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
