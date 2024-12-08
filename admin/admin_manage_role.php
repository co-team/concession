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

// Vérifier si les données ont été envoyées
if (isset($_POST['user_id']) && isset($_POST['role'])) {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    // Mettre à jour le rôle de l'utilisateur
    $sql = "UPDATE users SET role='$role' WHERE id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Rôle mis à jour avec succès !";
        header("Location: admin_dashboard.php");  // Rediriger vers le tableau de bord de l'administrateur
        exit();
    } else {
        echo "Erreur lors de la mise à jour du rôle : " . $conn->error;
    }
}

$conn->close();
?>
