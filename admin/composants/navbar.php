<?php

require_once ('db.php');
global $pdo;
$query = $pdo->query("SELECT * FROM settings");
$settings = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['settings_key']] = $row['settings_value'];
}
foreach ($settings as $key => $value):
      // $id=$settings['id'] ? htmlspecialchars($settings['id']) : 'Non défini';
        $titre=$settings['titre'] ? htmlspecialchars($settings['titre'] ): 'Non défini';
        $email=$settings['email'] ? htmlspecialchars($settings['email']) : 'Non défini';
          $logo=htmlspecialchars($settings['logo']);

  endforeach;
//$logo_path = "uploads/logo/" . htmlspecialchars($logo);
//if (file_exists($logo_path)) {
//    echo "Le fichier existe!";
//} else {
//    echo "Le fichier n'existe pas! Vérifiez le chemin.";
//}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titre); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.4-rc1/css/foundation.css">
</head>
<body>
<style>
*{
    font-family: Arial, sans-serif;
}
    @media screen and (max-width: 991px) {
        .navbar-brand {
            padding-left: 0.7em;
        }
        .navbar-nav {
            padding-top: 0.5em;
        }
    }
    .both-up {
        font-size: 6em;
        font-weight: bold;
        color: #222;
        letter-spacing: 1px;
        cursor: pointer;
        text-transform: uppercase;
        transition: 0.5s;
    }

    .both-up:hover {
        color: #fff;
        text-shadow: 0 0 5px #03e9f4,
        0 0 25px #03e9f4,
        0 0 50px #03e9f4,
        0 0 100px #03e9f4;
    }
    li {
        font-size: 1em;
        font-weight: bold;
        color: #5b5c5e !important;
        font-family: Arial, sans-serif;
        cursor: pointer;
        text-transform: uppercase;
        transition: 0.5s;
    }

    li:hover {
        color: #fff;
        text-shadow: 0 0 5px #03e9f4,
        0 0 25px #03e9f4,
        0 0 50px #03e9f4,
        0 0 100px #03e9f4;
    }
</style>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php" style="justify-content: flex-start;display: flex">
            <img src="./admin/uploads/logo/<?php echo htmlspecialchars($logo); ?>" alt="Logo" style="height: 40px;">
        </a>

        <!-- Titre -->
        <a class="navbar-brand both-up" href="#"><?php echo ucfirst($titre) ; ?></a>

        <!-- Bouton de menu pour mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto SMN_effect-2">
                <li class="nav-item"><a class="nav-link active text-white " aria-current="page" href="simulationscript.php">Simulation</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="liste_vehicules.php">Gestion des véhicules</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="./admin/admin_settings.php">Paramètres</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="./client/index.php">Comparer</a></li>
                <!-- Lien de contact avec l'email -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="mailto:<?php echo htmlspecialchars($titre); ?>" >Contact: <?php echo ucfirst($email); ?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
