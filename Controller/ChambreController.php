<?php
require_once(__DIR__ . '/../Bdd/bdd.php');
require_once(__DIR__ . '/../Model/ChambresModel.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class ChambresController {
    private $chambresModel;

    public function __construct(PDO $bdd) {
        $this->chambresModel = new ChambresModel($bdd);
    }

    public function handleRequest() {
        if (!isset($_POST['action'])) {
            return;
        }

        if (!$this->validateAdminAccess()) {
            header('Location: /ppe/index.php?page=chambres&erreur=Accès refusé');
            exit();
        }

        switch ($_POST['action']) {
            case 'ajouter':
                $this->addChambre($_POST, $_FILES);
                break;
            case 'modifier':
                $this->updateChambre($_POST);
                break;
            case 'supprimer':
                $this->deleteChambre($_POST['id']);
                break;
            default:
                header('Location: /ppe/index.php?page=chambres&erreur=Action invalide');
                exit();
        }
    }

    private function validateAdminAccess(): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['User_role'] === 'Admin';
    }

    public function getAllChambres() {
        return $this->chambresModel->getAllChambres();
    }

    private function addChambre(array $data, array $files) {
        $result = $this->chambresModel->addChambre($data, $files);
        if ($result) {
            header('Location: /ppe/index.php?page=chambres&message=Chambre ajoutée avec succès');
        } else {
            header('Location: /ppe/index.php?page=chambres&erreur=Erreur lors de l\'ajout de la chambre');
        }
        exit();
    }

    private function updateChambre(array $data) {
        $result = $this->chambresModel->updateChambre((int)$data['id'], $data);
        if ($result) {
            header('Location: /ppe/index.php?page=chambres&message=Chambre modifiée avec succès');
        } else {
            header('Location: /ppe/index.php?page=chambres&erreur=Erreur lors de la modification');
        }
        exit();
    }

    private function deleteChambre($id) {
        $result = $this->chambresModel->deleteChambre($id);
        if ($result) {
            header('Location: /ppe/index.php?page=chambres&message=Chambre supprimée avec succès');
        } else {
            header('Location: /ppe/index.php?page=chambres&erreur=Erreur lors de la suppression');
        }
        exit();
    }
}

// Entry point
$controller = new ChambresController($bdd);
$controller->handleRequest();
?>