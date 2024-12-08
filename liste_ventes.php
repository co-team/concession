<?php
global $pdo;
include 'db.php';

$sql = "SELECT ventes.*, clients.nom as client_nom, vehicules.marque, vehicules.modele
        FROM ventes
        JOIN clients ON ventes.client_id = clients.id
        JOIN vehicules ON ventes.vehicule_id = vehicules.id";
$stmt = $pdo->query($sql);
$ventes = $stmt->fetchAll();

foreach ($ventes as $vente) {
    echo "Client : " . $vente['client_nom'] . "<br>";
    echo "Véhicule : " . $vente['marque'] . " " . $vente['modele'] . "<br>";
    echo "Date de Vente : " . $vente['date_vente'] . "<br>";
    echo "Prix de Vente : " . $vente['prix_vente'] . "€<br><hr>";
}
?>
