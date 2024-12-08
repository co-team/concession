<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle 'admin'
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");  // Rediriger vers la page de connexion si non autorisé
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";  // Remplacez par votre nom d'utilisateur MySQL
$password = "";      // Remplacez par votre mot de passe MySQL
$dbname = "concessionnaire";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Obtenir la liste des utilisateurs
$sql = "SELECT id, username, email, role FROM users";
$result = $conn->query($sql);
?>
<style>

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
        font-weight: 500;
        color: #222;
        letter-spacing: 5px;
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

        color: #222;

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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
        <li><a href="admin_manage_users.php"><i class="fas fa-users"></i> Gestion des utilisateurs</a></li>
        <li><a href="admin_manage_vehicles.php"><i class="fas fa-car"></i> Gestion des véhicules</a></li>
        <li><a href="admin_settings.php"><i class="fas fa-cog"></i> Paramètres</a></li>
        <li><a href="settings.php"><i class="fas fa-add"></i> ajout Paramètres</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
    </ul>

</div>
<div class="main-content">
    <h1>Bienvenue <?php echo $_SESSION['username']; ?> sur le tableau de bord</h1>

    <p></p>

    <h2>Gestion des utilisateurs </h2>

    <table>
        <tr>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Modifier le rôle</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>
                        <form action='admin_manage_role.php' method='POST'>
                            <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                            <select name='role' required>
                                <option value='user' " . ($row['role'] == 'user' ? 'selected' : '') . ">Utilisateur</option>
                                <option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Administrateur</option>
                            </select>
                            <button type='submit'>Mettre à jour</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucun utilisateur trouvé.</td></tr>";
        }
        ?>
    </table>
</div>
</div>
</body>
</html>



