<?php
global $pdo;
session_start();

// Check if user is logged in and has the 'admin' role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require_once ('../db.php');

// Check if vehicle ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM vehicules WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Fetch the vehicle data
    if ($stmt->rowCount() > 0) {
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Véhicule non trouvé.";
        exit();
    }
}

// Update vehicle data if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $prix = $_POST['prix'];

    $sql = "UPDATE vehicules SET marque = :marque, modele = :modele, annee = :annee, prix = :prix WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'prix' => $prix, 'id' => $id])) {
        echo "Véhicule mis à jour avec succès.";
        header("Location: admin_manage_vehicles.php");
        exit();
    } else {
        echo "Erreur de mise à jour.";
    }
}
?>

<!-- HTML Form to Edit Vehicle -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Véhicule</title>
</head>
<body>
<h1>Modifier Véhicule</h1>
<form method="post">
    <label for="marque">Marque:</label>
    <input type="text" id="marque" name="marque" value="<?= htmlspecialchars($vehicle['marque']) ?>" required>

    <label for="modele">Modèle:</label>
    <input type="text" id="modele" name="modele" value="<?= htmlspecialchars($vehicle['modele']) ?>" required>

    <label for="annee">Année:</label>
    <input type="number" id="annee" name="annee" value="<?= htmlspecialchars($vehicle['annee']) ?>" required>

    <label for="prix">Prix:</label>
    <input type="number" id="prix" name="prix" value="<?= htmlspecialchars($vehicle['prix']) ?>" required>

    <button type="submit">Mettre à jour</button>
</form>
</body>
</html>
