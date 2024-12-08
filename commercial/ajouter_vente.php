<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $vehicule_id = $_POST['vehicule_id'];
    $prix_vente = $_POST['prix_vente'];
    $date_vente = date("Y-m-d");

    $sql = "INSERT INTO ventes (client_id, vehicule_id, date_vente, prix_vente) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$client_id, $vehicule_id, $date_vente, $prix_vente]);

    // Mettre à jour le stock du véhicule
    $sql = "UPDATE vehicules SET stock = stock - 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vehicule_id]);

    echo "Vente enregistrée avec succès.";
}
?>
<link rel="stylesheet" href="../style.css">
<form method="POST" action="">
    ID Client: <input type="number" name="client_id" required><br>
    ID Véhicule: <input type="number" name="vehicule_id" required><br>
    Prix de Vente: <input type="number" step="0.01" name="prix_vente" required><br>
    <button type="submit">Enregistrer Vente</button>
</form>
