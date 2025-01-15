<?php

class ChambreModel extends BaseModel {
    // Récupérer toutes les chambres
    public function getAll() {
        $query = $this->bdd->query("SELECT * FROM chambres");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une chambre par ID
    public function getById($id) {
        $stmt = $this->bdd->prepare("SELECT * FROM chambres WHERE id_chambre = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function __construct() {
    
        parent::__construct();
    }


}
?>
