<?php
global $pdo;
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['images'])) {
    $vehicule_id = $_POST['vehicule_id'];

    foreach ($_FILES['images']['name'] as $index => $nom_image) {
        $chemin_image = 'uploads/' . basename($nom_image);
        if (move_uploaded_file($_FILES['images']['tmp_name'][$index], $chemin_image)) {
            $sql = "INSERT INTO images_vehicules (vehicule_id, chemin_image) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$vehicule_id, $chemin_image]);
        }
    }

    echo "Images ajoutées avec succès.";
}
?>
<form method="POST" enctype="multipart/form-data">
    ID Véhicule: <input type="number" name="vehicule_id" value="<?= $_GET['id']  ?>" required><br>
    Images du véhicule: <input type="file" name="images[]" multiple><br>
    <button type="submit" name="ajouter_images">Ajouter Images</button>
</form>
