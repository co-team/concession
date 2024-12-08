<?php
// Inclure votre fichier de connexion à la base de données
global $pdo;
include('db.php');

// Récupérer les paramètres actuels
$sql = "SELECT * FROM settings WHERE id = 1";  // Adaptez l'ID en fonction de votre configuration
$result = $pdo->query($sql);
$settings = $result->fetchAll(PDO::FETCH_OBJ);

// Mettre à jour les paramètres si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $email = $_POST['email'];

    // Gestion du logo
    if (!empty($_FILES['logo']['name'])) {
        $logo = time() . '_' . basename($_FILES['logo']['name']);
        move_uploaded_file($_FILES['logo']['tmp_name'], "logo/" . $logo);
    } else {
        $logo = $settings['logo'];  // Conserver l'ancien logo s'il n'est pas modifié
    }

    // Mettre à jour dans la base de données
    $sql = "UPDATE settings SET titre = '$titre', email = '$email', logo = '$logo' WHERE id = 1";
    $pdo->query($sql);
    header('Location: settings.php'); // Rediriger pour éviter un resoumission de formulaire
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres du Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Paramètres du Site</h1>

    <!-- Formulaire pour modifier les paramètres -->
    <form action="settings.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre du Site</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($settings['titre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email de Contact</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($settings['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo du Site</label>
            <input type="file" class="form-control" id="logo" name="logo">
            <?php if ($settings['logo']): ?>
                <img src="logo/<?= htmlspecialchars($settings['logo']) ?>" alt="Logo actuel" style="max-width: 100px; margin-top: 10px;">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
