<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $credit_id = $_POST['credit_id'];
    $mois_paye = $_POST['mois_paye'];

    $sql = "UPDATE credits SET mois_paye = mois_paye + ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$mois_paye, $credit_id]);

    echo "Mise à jour des paiements réussie.";
}
?>
