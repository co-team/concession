<?php
global $pdo;
include 'db.php';

$sql = "SELECT options_finitions.*, vehicules.marque, vehicules.modele FROM options_finitions
        JOIN vehicules ON options_finitions.vehicule_id = vehicules.id";
$stmt = $pdo->query($sql);
$options = $stmt->fetchAll();

foreach ($options as $option) {
    echo "Véhicule : " . $option['marque'] . " " . $option['modele'] . "<br>";
    echo "Option : " . $option['option_nom'] . "<br>";
    echo "Description : " . $option['option_description'] . "<br>";
    echo "Prix : " . $option['prix'] . "€<br><hr>";
}
?>
