<?php
include('../Model/PhotoModel.php');
include('../Bdd/bdd.php');

class PhotoController {
    private $photoModel;

    public function __construct($bdd) {
        $this->photoModel = new PhotoModel($bdd);
    }

    public function handleRequest() {
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
                    header('Location: ../index.php?page=photos');
                    break;
            }
        }
    }

    private function ajouterPhoto() {
        if (isset($_FILES['image']['tmp_name'], $_POST['description'])) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
            $description = htmlspecialchars($_POST['description']);

            if ($this->photoModel->ajouterPhoto($image, $description)) {
                header('Location: ../index.php?page=photos&message=Photo ajoutée avec succès');
            } else {
                header('Location: ../index.php?page=photos&error=Erreur lors de l\'ajout');
            }
        }
    }

    private function modifierPhoto() {
        if (isset($_POST['id'], $_POST['description'])) {
            $id = (int)$_POST['id'];
            $description = htmlspecialchars($_POST['description']);

            if ($this->photoModel->modifierPhoto($id, $description)) {
                header('Location: ../index.php?page=photos&message=Photo modifiée avec succès');
            } else {
                header('Location: ../index.php?page=photos&error=Erreur lors de la modification');
            }
        }
    }

    private function supprimerPhoto() {
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];

            if ($this->photoModel->supprimerPhoto($id)) {
                header('Location: ../index.php?page=photos&message=Photo supprimée avec succès');
            } else {
                header('Location: ../index.php?page=photos&error=Erreur lors de la suppression');
            }
        }
    }
}

$controller = new PhotoController($bdd);
$controller->handleRequest();
?>
