<?php
global $pdo;
include '../db.php';

// Code pour afficher le formulaire d'ajout de véhicule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_vehicule'])) {
    // Insérer le véhicule dans la base
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO vehicules (marque, modele, annee, prix, stock) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$marque, $modele, $annee, $prix, $stock]);

    // Récupérer l'ID du véhicule nouvellement ajouté
    $vehicule_id = $pdo->lastInsertId();

    // Insérer les caractéristiques du véhicule
    $type_moteur = $_POST['type_moteur'];
    $transmission = $_POST['transmission'];
    $carburant = $_POST['carburant'];
    $puissance = $_POST['puissance'];
    $couleur = $_POST['couleur'];
    $nb_portes = $_POST['nb_portes'];
    $description = $_POST['description'];

    $sql = "INSERT INTO caracteristiques (vehicule_id, type_moteur, transmission, carburant, puissance, couleur, nb_portes, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vehicule_id, $type_moteur, $transmission, $carburant, $puissance, $couleur, $nb_portes, $description]);

    // Téléversement de l'image
    if (!empty($_FILES['image']['name'])) {
        $chemin_image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $chemin_image);

        $sql = "INSERT INTO images_vehicules (vehicule_id, chemin_image) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$vehicule_id, $chemin_image]);
    }

    echo "Véhicule et caractéristiques ajoutés avec succès.";
}
?>
