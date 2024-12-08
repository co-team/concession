<?php
function calculMensualite($montant, $taux_interet, $duree) {
    $taux_mensuel = $taux_interet / 100 / 12;
    $mensualite = $montant * $taux_mensuel / (1 - pow(1 + $taux_mensuel, -$duree));
    return round($mensualite, 2);
}

// Exemple d'utilisation
$prix = 20000; // Prix du véhicule
$taux_interet = 5; // 5% de taux d'intérêt annuel
$duree = 60; // 5 ans

echo "Mensualité : " . calculMensualite($prix, $taux_interet, $duree) . "€";
?>
