<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicule_id = $_POST['vehicule_id'];
    $duree = $_POST['duree'];
    $taux_interet = $_POST['taux_interet'];
    $mensualite = $_POST['mensualite'];
    $montant_total = $_POST['montant_total'];
    $type_financement = $_POST['type_financement'];

    $sql = "INSERT INTO financements (vehicule_id, duree, taux_interet, mensualite, montant_total, type_financement) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vehicule_id, $duree, $taux_interet, $mensualite, $montant_total, $type_financement]);

    echo "Financement ajouté avec succès.";
}
?>
<link rel="stylesheet" href="../style.css">
<form method="POST" action="">
    ID Véhicule: <input type="number" name="vehicule_id" required><br>
    Durée (mois): <input type="number" name="duree" required><br>
    Taux d'Intérêt (%): <input type="number" step="0.01" name="taux_interet" required><br>
    Mensualité: <input type="number" step="0.01" name="mensualite" required><br>
    Montant Total: <input type="number" step="0.01" name="montant_total" required><br>
    Type de Financement: 
    <select name="type_financement" required>
        <option value="crédit">Crédit</option>
        <option value="leasing">Leasing</option>
    </select><br>
    <button type="submit">Ajouter Financement</button>
</form>
