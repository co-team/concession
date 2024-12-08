<?php
include 'db.php';

$sql = "SELECT financements.*, vehicules.marque, vehicules.modele FROM financements
        JOIN vehicules ON financements.vehicule_id = vehicules.id";
$stmt = $pdo->query($sql);
$financements = $stmt->fetchAll();

foreach ($financements as $financement) {
    echo "Véhicule : " . $financement['marque'] . " " . $financement['modele'] . "<br>";
    echo "Durée : " . $financement['duree'] . " mois<br>";
    echo "Taux d'Intérêt : " . $financement['taux_interet'] . "%<br>";
    echo "Mensualité : " . $financement['mensualite'] . "€<br>";
    echo "Montant Total : " . $financement['montant_total'] . "€<br>";
    echo "Type de Financement : " . $financement['type_financement'] . "<br><hr>";
}
?>
