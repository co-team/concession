<?php
//session_start();

// Vérification des autorisations (seulement les administrateurs peuvent modifier les paramètres)
//if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
//    header("Location: login.php");
//    exit();
//}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "concessionnaire";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement des données du formulaire
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $email = $_POST['email'];
    $logo = '';

// Gestion du téléchargement de fichier pour le logo
    if (!empty($_FILES['logo']['name'])) {
        $logo_tmp = $_FILES['logo']['tmp_name'];
        $logo_name = basename($_FILES['logo']['name']);
        $logo_extension = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));

        // Vérifiez que le fichier est une image
        if (in_array($logo_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $logo = time() . '_' . $logo_name;
            $logo_path = "uploads/logo/" . $logo;

            // Déplacez le fichier dans le dossier approprié
            if (move_uploaded_file($logo_tmp, $logo_path)) {
                // Le téléchargement a réussi
            } else {
                // Gestion des erreurs de téléchargement
                echo "Erreur lors du téléchargement de l'image.";
                exit;
            }
        } else {
            echo "Veuillez télécharger un fichier d'image valide (jpg, jpeg, png, gif).";
            exit;
        }
    } else {
        // Si aucun fichier n'est téléchargé, utilisez un logo par défaut ou laissez-le vide
        $logo = null;
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM settings WHERE id = $id");
            header("Location: settings.php");
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Paramètres</title>
</head>
<body>

<h2>Ajouter ou Modifier les Paramètres</h2>
<form action="update_settings.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo isset($setting['id']) ? $setting['id'] : ''; ?>">

    <label for="titre">Titre :</label>
    <input type="text" name="titre" id="titre" value="<?php echo isset($setting['titre']) ? $setting['titre'] : ''; ?>" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" value="<?php echo isset($setting['email']) ? $setting['email'] : ''; ?>" required><br>

    <label for="logo">Logo :</label>
    <input type="file" name="logo" id="logo"><br>

    <?php if (isset($setting['logo'])): ?>
        <img src="./path/to/logos/<?php echo htmlspecialchars($setting['logo']); ?>" alt="Logo actuel" style="height: 50px;">
    <?php endif; ?>

    <button type="submit" name="save">Enregistrer</button>
</form>

</body>
</html>
