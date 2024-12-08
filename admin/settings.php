<?php
global $pdo;
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require_once('../db.php');

// Récupérer les paramètres actuels
$settingsQuery = $pdo->query("SELECT * FROM settings");
$settingsRows = $settingsQuery->fetchAll(PDO::FETCH_ASSOC);
$settings = [];
foreach ($settingsRows as $row) {
    $settings[$row['settings_key']] = $row['settings_value'];
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $email = $_POST['email'];

    // Gérer le téléchargement du logo
    if (!empty($_FILES['logo']['name'])) {
        $logo_name = basename($_FILES['logo']['name']);
        $target_dir = "./uploads/logo/"; // Répertoire pour stocker les logos
        $target_file = $target_dir . $logo_name;

        // Déplacer le fichier téléchargé
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
            // Mettre à jour le paramètre 'logo' dans la base de données
            $pdo->prepare("REPLACE INTO settings (settings_key, settings_value) VALUES ('logo', ?)")->execute([$logo_name]);
        } else {
            echo "Échec du téléchargement du logo.";
        }
    }

    // Mettre à jour les paramètres titre et email
    $pdo->prepare("REPLACE INTO settings (settings_key, settings_value) VALUES ('titre', ?), ('email', ?)")->execute([$titre, $email]);

    header("Location: settings.php"); // Recharger la page
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres du Site</title>
</head>
<body>
<h1>Paramètres du Site</h1>
<form method="post" action="settings.php" enctype="multipart/form-data">
    <label for="titre">Titre :</label>
    <input type="text" name="titre" value="<?= htmlspecialchars($settings['titre'] ?? '') ?>" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($settings['email'] ?? '') ?>" required><br>

    <label for="logo">Logo :</label>
    <input type="file" name="logo" accept="image/*"><br>

    <?php if (!empty($settings['logo'])): ?>
        <img src="./uploads/logo/<?= htmlspecialchars($settings['logo']) ?>" alt="Logo actuel" style="max-width: 100px;"><br>
    <?php endif; ?>

    <button type="submit">Enregistrer</button>
</form>
</body>
</html>
