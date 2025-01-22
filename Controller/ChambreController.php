<!-- ChambreController.php-->
<?php
include ('./Bdd/bdd.php');
include ('./Model/ChambreModel.php');
class ChambresController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'add':
                        $this->addChambre($_POST);
                        break;
                    case 'update':
                        $this->updateChambre($_POST);
                        break;
                    case 'delete':
                        $this->deleteChambre($_POST['id']);
                        break;
                    case 'show ':
                        $this->showChambres($_POST);
                        break;
                    case 'getChambre':
                        $this->getChambreById($_POST['id']);
                        break;
                    case 'getAll':
                        $this->getAllChambres();
                        break;

                    default:
                            echo "Action non reconnue.";
                            break;        
                }
            }
        } else {
            $this->showChambres();
        }
    }

    private function addChambre($data) {
        if ($_SESSION['user']['User_role'] === 'Admin') {
            if ($this->model->addChambre($data)) {
                echo "Chambre ajoutée avec succès.";
            } else {
                echo "Échec de l'ajout de la chambre.";
            }
        } else {
            echo "Accès refusé.";
        }
    }

    private function updateChambre($data) {
        if ($_SESSION['user']['User_role'] === 'Admin') {
            if ($this->model->updateChambre($data['id'], $data)) {
                echo "Chambre modifiée avec succès.";
            } else {
                echo "Échec de la modification de la chambre.";
            }
        } else {
            echo "Accès refusé.";
        }
    }

    private function deleteChambre($id) {
        if ($_SESSION['user']['User_role'] === 'Admin') {
            if ($this->model->deleteChambre($id)) {
                echo "Chambre supprimée avec succès.";
            } else {
                echo "Échec de la suppression de la chambre.";
            }
        } else {
            echo "Accès refusé.";
        }
    }

    private function showChambres() {
        $chambres = $this->model->getAllChambres();
        include('../Vue/ChambresView.php');
    }
}
