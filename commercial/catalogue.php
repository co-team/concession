<?php
include 'db.php';

$sql = "SELECT vehicules.*, caracteristiques.*, images_vehicules.chemin_image
        FROM vehicules
        LEFT JOIN caracteristiques ON vehicules.id = caracteristiques.vehicule_id
        LEFT JOIN images_vehicules ON vehicules.id = images_vehicules.vehicule_id";
$stmt = $pdo->query($sql);
$vehicules = $stmt->fetchAll();
?>
<link rel="stylesheet" href="../style.css">
<?php
foreach ($vehicules as $vehicule) {
    echo "<h2>" . $vehicule['marque'] . " " . $vehicule['modele'] . "</h2>";
    echo "<img src='" . $vehicule['chemin_image'] . "' alt='Image du véhicule' width='200'><br>";
    echo "Année: " . $vehicule['annee'] . "<br>";
    echo "Prix: " . $vehicule['prix'] . "€<br>";
    echo "Type de moteur: " . $vehicule['type_moteur'] . "<br>";
    echo "Transmission: " . $vehicule['transmission'] . "<br>";
    echo "Carburant: " . $vehicule['carburant'] . "<br>";
    echo "Puissance: " . $vehicule['puissance'] . " ch<br>";
    echo "Couleur: " . $vehicule['couleur'] . "<br>";
    echo "Description: " . $vehicule['description'] . "<br><hr>";
}
?>
