<!-- ChambreModel.php-->
<?php
include ('./Bdd/bdd.php');
class ChambresModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllChambres() {
        $query = "SELECT * FROM Chambres";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChambreById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Chambres WHERE ID_Chambres = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addChambre($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO Chambres (Images, Chambre_000, Type_Chambre, Stat, Prix, Descriptif) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['Images'],
            $data['Chambre_000'],
            $data['Type_Chambre'],
            $data['Stat'],
            $data['Prix'],
            $data['Descriptif']
        ]);
    }

    public function updateChambre($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE Chambres SET Images = ?, Chambre_000 = ?, Type_Chambre = ?, Stat = ?, Prix = ?, Descriptif = ? WHERE ID_Chambres = ?"
        );
        return $stmt->execute([
            $data['Images'],
            $data['Chambre_000'],
            $data['Type_Chambre'],
            $data['Stat'],
            $data['Prix'],
            $data['Descriptif'],
            $id
        ]);
    }

    public function deleteChambre($id) {
        $stmt = $this->db->prepare("DELETE FROM Chambres WHERE ID_Chambres = ?");
        return $stmt->execute([$id]);
    }
}
