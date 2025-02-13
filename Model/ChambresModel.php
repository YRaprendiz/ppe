<!-- ChambresModel.php -->
<?php
class ChambresModel {
    private $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getAllChambres(): array {
        try {
            $query = "SELECT c.*, 
                      CASE 
                          WHEN r.ID_Reservation IS NULL OR r.Date_Fin < CURRENT_DATE THEN 1
                          ELSE 0
                      END as Statut
                      FROM Chambres c
                      LEFT JOIN Reservations r ON c.ID_Chambres = r.ID_Chambres 
                      AND r.Date_Debut <= CURRENT_DATE 
                      AND r.Date_Fin >= CURRENT_DATE";
            $stmt = $this->bdd->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching chambres: " . $e->getMessage());
            return [];
        }
    }

    public function getChambreById(int $id): ?array {
        try {
            $stmt = $this->bdd->prepare("SELECT * FROM Chambres WHERE ID_Chambres = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching chambre: " . $e->getMessage());
            return null;
        }
    }

    public function addChambre(array $data): bool {
        try {
            $imageData = $this->processImageUpload();
            $stmt = $this->bdd->prepare(
                "INSERT INTO Chambres (Images, Chambre_000, Type_Chambre, Stat, Prix, Descriptif) 
                 VALUES (:Images, :Chambre_000, :Type_Chambre, :Stat, :Prix, :Descriptif)"
            );
            $data['Images'] = $imageData;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Error adding chambre: " . $e->getMessage());
            return false;
        }
    }

    private function processImageUpload(): ?string {
        if (isset($_FILES['Images']) && $_FILES['Images']['error'] === UPLOAD_ERR_OK) {
            $imageContent = file_get_contents($_FILES['Images']['tmp_name']);
            return $imageContent;
        }
        return null;
    }

    public function updateChambre(int $id, array $data): bool {
        try {
            $imageData = $this->processImageUpload() ?? $data['existing_image'];
            $stmt = $this->bdd->prepare(
                "UPDATE Chambres SET Images = :Images, Chambre_000 = :Chambre_000, 
                 Type_Chambre = :Type_Chambre, Stat = :Stat, Prix = :Prix, Descriptif = :Descriptif 
                 WHERE ID_Chambres = :id"
            );
            $data['Images'] = $imageData;
            $data['id'] = $id;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Error updating chambre: " . $e->getMessage());
            return false;
        }
    }

    public function deleteChambre(int $id): bool {
        try {
            $stmt = $this->bdd->prepare("DELETE FROM Chambres WHERE ID_Chambres = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting chambre: " . $e->getMessage());
            return false;
        }
    }

    public function getPhotosByChambreId($chambreId) {
        $stmt = $this->bdd->prepare("SELECT Photo FROM Photos WHERE ID_Chambre = :chambreId");
        $stmt->bindParam(':chambreId', $chambreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
