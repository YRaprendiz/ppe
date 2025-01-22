<?php
include('../Model/ChambreModel.php');
include('../Bdd/bdd.php');

class ChambreController {
    private $chambreModel;

    public function __construct($bdd) {
        $this->chambreModel = new ChambreModel($bdd);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;

            switch ($action) {
                case 'ajouter':
                    $this->ajouterChambre();
                    break;
                case 'modifier':
                    $this->modifierChambre();
                    break;
                case 'supprimer':
                    $this->supprimerChambre();
                    break;
                default:
                    header('Location: ../index.php?page=chambres');
                    break;
            }
        }
    }

    private function ajouterChambre() {
        if (isset($_FILES['image']['tmp_name'], $_POST['chambreCode'], $_POST['type'], $_POST['prix'], $_POST['descriptif'])) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
            $chambreCode = htmlspecialchars($_POST['chambreCode']);
            $type = $_POST['type'];
            $prix = (float)$_POST['prix'];
            $descriptif = htmlspecialchars($_POST['descriptif']);

            if ($this->chambreModel->ajouterChambre($image, $chambreCode, $type, $prix, $descriptif)) {
                header('Location: ../index.php?page=chambres&message=Chambre ajoutée avec succès');
            } else {
                header('Location: ../index.php?page=chambres&error=Erreur lors de l\'ajout');
            }
        }
    }

    private function modifierChambre() {
        if (isset($_POST['id'], $_POST['type'], $_POST['prix'], $_POST['descriptif'])) {
            $id = (int)$_POST['id'];
            $type = $_POST['type'];
            $prix = (float)$_POST['prix'];
            $descriptif = htmlspecialchars($_POST['descriptif']);

            if ($this->chambreModel->modifierChambre($id, $type, $prix, $descriptif)) {
                header('Location: ../index.php?page=chambres&message=Chambre modifiée avec succès');
            } else {
                header('Location: ../index.php?page=chambres&error=Erreur lors de la modification');
            }
        }
    }

    private function supprimerChambre() {
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];

            if ($this->chambreModel->supprimerChambre($id)) {
                header('Location: ../index.php?page=chambres&message=Chambre supprimée avec succès');
            } else {
                header('Location: ../index.php?page=chambres&error=Erreur lors de la suppression');
            }
        }
    }
}

$controller = new ChambreController($bdd);
$controller->handleRequest();
?>
