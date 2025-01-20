<!--  ModelChambre.php -->
  <?php
//include('./bdd.php');
class BaseModel {
    public $bdd;

    public function __construct() {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=ppe_hotel', 'root', '');

        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage() . "<br>");
        }
    }
}

class FlashMessage {
    public static function set($type, $message) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash'] = [            'type' => $type,            'message' => $message        ];
    }

    public static function display() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['flash'])) {
            $type = $_SESSION['flash']['type'];
            $message = $_SESSION['flash']['message'];
            echo "<div class='alert alert-{$type} text-center'>{$message}</div>";
            unset($_SESSION['flash']);
        }
    }
}

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
    // Ajouter une chambre 
    public function addChambre($chambres_number, $chambre_type, $prix, $status, $description = null, $image = null) {
        $stmt = $this->bdd->prepare("INSERT INTO CHAMBRES (chambres_number, chambre_type, prix, status, description, image) 
                                     VALUES (:chambres_number, :chambre_type, :prix, :status, :description, :image)");
        $stmt->execute([
            'chambres_number' => $chambres_number,
            'chambre_type' => $chambre_type,
            'prix' => $prix,
            'status' => $status,
            'description' => $description,
            'image' => $image
        ]);
    }
    

}
?>
