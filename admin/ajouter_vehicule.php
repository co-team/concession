<?php
require_once ('./composants/nav2.php');
?>
<link rel="stylesheet" href="../style.css">
<center>
<div class="container">




        <div class="col-md-8">
<form method="POST" action="dashboard_admin.php" enctype="multipart/form-data">
    <div class="card">
    <h3>Ajouter un Véhicule</h3>
    Marque: <input type="text" name="marque" required><br>
    Modèle: <input type="text" name="modele" required><br>
    Année: <input type="number" name="annee" required><br>


    Prix: <input type="number" step="0.01" name="prix" required><br>
    Stock: <input type="number" name="stock" required><br><br>
    Description: <textarea name="description" required></textarea><br><br>

        <hr>
    <h3>Caractéristiques</h3>
        <hr>
    Type de moteur: <input type="text" name="type_moteur" required><br>
    Transmission: <input type="text" name="transmission" required><br>
    Carburant: <input type="text" name="carburant" required><br>


    Puissance (ch): <input type="number" name="puissance" required><br>
    Couleur: <input type="text" name="couleur" required><br>
    Nombre de portes: <input type="number" name="nb_portes" required><br>




    <button type="submit" name="ajouter_vehicule">Ajouter Véhicule</button>

</form>
</div>
</div>
</center>