<?php
global $pdo;
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicule_id = $_POST['vehicule_id'];
    $option_nom = $_POST['option_nom'];
    $option_description = $_POST['option_description'];
    $prix = $_POST['prix'];

    $sql = "INSERT INTO options_finitions (vehicule_id, option_nom, option_description, prix) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vehicule_id, $option_nom, $option_description, $prix]);

    echo "Option ajoutée avec succès.";
}
?>
<link rel="stylesheet" href="../style.css">
<form method="POST" action="">
    ID Véhicule: <input type="number" name="vehicule_id" required><br>
    Nom de l'option: <input type="text" name="option_nom" required><br>
    Description: <textarea name="option_description" required></textarea><br>
    Prix: <input type="number" step="0.01" name="prix" required><br>
    <button type="submit">Ajouter Option</button>
</form>
