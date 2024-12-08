<style>
    /* Conteneur principal pour la comparaison */
    .compare-container {
        display: flex;
        /*justify-content: space-between;*/
        /*margin: 20px;*/
        gap: 20px;
    }

    /* Style de la table pour les caractéristiques */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table th, table td {
        padding: 8px 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    table th {
        width: 30%;
    }

    table td {
        width: 70%;
    }

    table th i {
        margin-right: 8px;
    }

    /* Style pour les titres de véhicules */
    .vehicle-title {
        font-size: 1.5em;
        margin-bottom: 10px;
        text-align: center;
    }

    /* Image du véhicule avec taille responsive */
    .vehicle-image {
        width: 95%;
        height: 35%;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Style pour chaque carte de véhicule */
    .vehicle-card {
        width: 30%;
        height: 750px;
        padding: 20px;
        border: 2px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
      margin-left: 200px;
    }

    /* Responsive : Adaptation pour les écrans plus petits */
    @media (max-width: 768px) {
        .compare-container {
            flex-direction: column;
            align-items: center;
        }
        .vehicle-card {
            width: 90%;
        }
    }
    .vehicle-card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
</style>
<!-- Add Font Awesome CDN link to your HTML head -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<meta charset="UTF-8">
<?php
global $pdo;
require_once ('../admin/composants/nav2.php');
require '../db.php';
if (isset($_POST['vehicle1']) && isset($_POST['vehicle2'])) {
    $vehicle1_id = $_POST['vehicle1'];
    $vehicle2_id = $_POST['vehicle2'];

    $sql = "SELECT v.id, v.marque, v.modele, v.annee, v.prix, v.stock, i.chemin_image,
c.type_moteur, c.transmission, c.carburant, c.puissance,
c.couleur, c.nb_portes, c.description
FROM vehicules v
JOIN images_vehicules i ON v.id = i.vehicule_id
JOIN caracteristiques c ON v.id = c.vehicule_id
WHERE v.id IN (?, ?) GROUP BY( v.id)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vehicle1_id, $vehicle2_id]);
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($vehicles) == 2) {
        // Comparaison des deux véhicules
        list($vehicle1, $vehicle2) = $vehicles;
        // Code de la comparaison ici
        //var_dump($vehicles);
    } else {
        if (empty($vehicle1_id) || empty($vehicle2_id)) {
            echo "Veuillez sélectionner deux véhicules à comparer.";
        } else {
            echo "Erreur lors de la récupération des informations. Assurez-vous que les véhicules existent.";
        }
    }

    if (count($vehicles) < 2) {
        echo "L'un des véhicules ou leurs caractéristiques sont manquants pour les ID donnés.";
        // Affiche le résultat pour vérifier ce qui est trouvé
    } else {
        list($vehicle1, $vehicle2) = $vehicles;
        //var_dump($vehicle1, $vehicle2);
// Affichage de la comparaison
        echo "<div class='compare-container my-5'>
            <div class='vehicle-card'>
            <a href='index.php'>
                <h2 class='vehicle-title'>{$vehicle1['marque']} {$vehicle1['modele']}</h2>
                </a>
                <img src='../admin/{$vehicle1['chemin_image']}' alt='Image du véhicule 1' class='vehicle-image'>
               <table>
                    <tr><th><i class='fas fa-calendar'></i> Année</th><td>{$vehicle1['annee']}</td></tr>
                    <tr><th><i class='fas fa-euro-sign'></i> Prix</th><td>{$vehicle1['prix']} €</td></tr>
                    <tr><th><i class='fas fa-cogs'></i> Type de Moteur</th><td>{$vehicle1['type_moteur']}</td></tr>
                    <tr><th><i class='fas fa-exchange-alt'></i> Transmission</th><td>{$vehicle1['transmission']}</td></tr>
                    <tr><th><i class='fas fa-tint'></i> Carburant</th><td>{$vehicle1['carburant']}</td></tr>
                    <tr><th><i class='fas fa-tachometer-alt'></i> Puissance</th><td>{$vehicle1['puissance']} CV</td></tr>
                    <tr><th><i class='fas fa-paint-brush'></i> Couleur</th><td>{$vehicle1['couleur']}</td></tr>
                    <tr><th><i class='fas fa-door-closed'></i> Nombre de Portes</th><td>{$vehicle1['nb_portes']}</td></tr>
                </table>
            </div>
            <div class='vehicle-card'>
            <a href='index.php'>
                <h2 class='vehicle-title'>{$vehicle2['marque']} {$vehicle2['modele']}</h2>
                </a>
                <img src='../admin/{$vehicle2['chemin_image']}' alt='Image du véhicule 1' class='vehicle-image'>
                <table >
               
                <tr><th><i class='fas fa-calendar'></i> Année</th><td>{$vehicle2['annee']}</td></tr>
                    <tr><th><i class='fas fa-euro-sign'></i> Prix</th><td>{$vehicle2['prix']} €</td></tr>
                    <tr><th><i class='fas fa-cogs'></i> Type de Moteur</th><td>{$vehicle2['type_moteur']}</td></tr>
                    <tr><th><i class='fas fa-exchange-alt'></i> Transmission</th><td>{$vehicle2['transmission']}</td></tr>
             
                    
                    <tr><th><i class='fas fa-tint'></i> Carburant</th><td>{$vehicle2['carburant']}</td></tr>
                    <tr><th><i class='fas fa-tachometer-alt'></i> Puissance</th><td>{$vehicle2['puissance']} CV</td></tr>
                    <tr><th><i class='fas fa-paint-brush'></i> Couleur</th><td>{$vehicle2['couleur']}</td></tr>
                    <tr><th><i class='fas fa-door-closed'></i> Nombre de Portes</th><td>{$vehicle2['nb_portes']}</td></tr>
                </table>
            </div>
          </div>";
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

