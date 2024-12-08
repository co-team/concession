<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prix = $_POST['prix'];
    $reprise = $_POST['reprise'];
    $taux_interet = $_POST['taux_interet'];
    $duree = $_POST['duree'];

    $montant_financement = $prix - $reprise;
    $taux_mensuel = $taux_interet / 100 / 12;
    $mensualite = $montant_financement * $taux_mensuel / (1 - pow(1 + $taux_mensuel, -$duree));

    echo "Montant de financement : " . round($montant_financement, 2) . "€<br>";
    echo "Mensualité estimée : " . round($mensualite, 2) . "€<br>";
    echo "Durée : " . $duree . " mois<br>";
}
?>
