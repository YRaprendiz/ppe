<?php
include('./ControllerChambre.php');
include 'VueNavbar.php'; 
renderNavbar();

$controller = new ChambreController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chambres_number = $_POST['chambres_number'];
    $chambre_type = $_POST['chambre_type'];
    $prix = $_POST['prix'];
    $status = $_POST['status'];
    $description = $_POST['description'] ?? null;
    $image = null;

    if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    $controller->add($chambres_number, $chambre_type, $prix, $status, $description, $image);
    header('Location: VueChambre.php');
    exit;
}
?>

<div class="container my-5">
    <h1>Ajouter une Chambre</h1>
    <?php FlashMessage::display(); ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="chambres_number" class="form-label">Numéro de Chambre</label>
            <input type="text" class="form-control" id="chambres_number" name="chambres_number" required>
        </div>
        <div class="mb-3">
            <label for="chambre_type" class="form-label">Type de Chambre</label>
            <input type="text" class="form-control" id="chambre_type" name="chambre_type" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix par Nuit (€)</label>
            <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-select" id="status" name="status" required>
                <option value="disponible">Disponible</option>
                <option value="reserve">Réservée</option>
                <option value="hors de service">Hors de Service</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description (optionnel)</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image (optionnel)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
<?php
renderFooter();
?>
