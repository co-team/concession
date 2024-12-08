<?php
include 'db.php';

$sql = "SELECT credits.*, vehicules.marque, vehicules.modele
        FROM credits
        JOIN vehicules ON credits.vehicule_id = vehicules.id
        WHERE credits.mois_paye < credits.duree";
$stmt = $pdo->query($sql);
$credits = $stmt->fetchAll();

foreach ($credits as $credit) {
    $montant_restant = ($credit['duree'] - $credit['mois_paye']) * $credit['montant_mensuel'];
    
    echo "Véhicule : " . $credit['marque'] . " " . $credit['modele'] . "<br>";
    echo "Montant total du crédit : " . $credit['montant_total'] . "€<br>";
    echo "Mensualité : " . $credit['montant_mensuel'] . "€<br>";
    echo "Durée : " . $credit['duree'] . " mois<br>";
    echo "Mois payés : " . $credit['mois_paye'] . "<br>";
    echo "Montant restant dû : " . round($montant_restant, 2) . "€<br><hr>";
}
?>
