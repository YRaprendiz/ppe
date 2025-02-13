<?php
require_once(__DIR__ . '/../Model/PhotoModel.php');
require_once(__DIR__ . '/../Bdd/bdd.php');

class ControleurPhoto {
    private $modelePhoto;

    public function __construct($bdd) {
        $this->modelePhoto = new PhotoModel($bdd);
    }

    public function gererRequete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;

            switch ($action) {
                case 'ajouter':
                    $this->ajouterPhoto();
                    break;
                case 'modifier':
                    $this->modifierPhoto();
                    break;
                case 'supprimer':
                    $this->supprimerPhoto();
                    break;
                default:
                    header('Location: /ppe/index.php?page=photos&erreur=Action invalide');
                    exit();
            }
        }
    }

    private function ajouterPhoto() {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            header('Location: /ppe/index.php?page=photos&erreur=Erreur lors du téléchargement de l\'image');
            exit();
        }

        $donneesImage = file_get_contents($_FILES['image']['tmp_name']);
        $description = $_POST['description'] ?? '';
        $idChambre = !empty($_POST['id_chambre']) ? $_POST['id_chambre'] : null;

        if ($this->modelePhoto->ajouterPhoto($donneesImage, $description, $idChambre)) {
            header('Location: /ppe/index.php?page=photos&message=Photo ajoutée avec succès');
        } else {
            header('Location: /ppe/index.php?page=photos&erreur=Erreur lors de l\'ajout de la photo');
        }
        exit();
    }

    private function modifierPhoto() {
        $id = $_POST['id'] ?? null;
        $description = $_POST['description'] ?? '';
        $idChambre = !empty($_POST['id_chambre']) ? $_POST['id_chambre'] : null;

        if ($this->modelePhoto->modifierPhoto($id, $description, $idChambre)) {
            header('Location: /ppe/index.php?page=photos&message=Photo modifiée avec succès');
        } else {
            header('Location: /ppe/index.php?page=photos&erreur=Erreur lors de la modification');
        }
        exit();
    }

    private function supprimerPhoto() {
        $id = $_POST['id'] ?? null;

        if ($this->modelePhoto->supprimerPhoto($id)) {
            header('Location: /ppe/index.php?page=photos&message=Photo supprimée avec succès');
        } else {
            header('Location: /ppe/index.php?page=photos&erreur=Erreur lors de la suppression');
        }
        exit();
    }
}

$controleur = new ControleurPhoto($bdd);
$controleur->gererRequete();

class PhotoController {
    private $photoModel;

    public function __construct() {
        $this->photoModel = new PhotoModel($GLOBALS['bdd']);
    }

    public function getPhotos() {
        $photos = $this->photoModel->getPhotos();
        $photo4 = null;
        $photo5 = null;

        foreach ($photos as $photo) {
            if ($photo['ID_Photos'] == 4) {
                $photo4 = $photo;
            }
            if ($photo['ID_Photos'] == 5) {
                $photo5 = $photo;
            }
        }

        return ['photo4' => $photo4, 'photo5' => $photo5];
    }
}
?>
