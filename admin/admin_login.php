<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";  // Remplacez par votre nom d'utilisateur MySQL
$password = "";      // Remplacez par votre mot de passe MySQL
$dbname = "concessionnaire";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            // Connexion réussie, initialiser la session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirection selon le rôle de l'utilisateur
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");  // Tableau de bord administrateur
            } else {
                header("Location:../commercial/user_dashboard.php");   // Tableau de bord utilisateur
            }
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Nom d'utilisateur non trouvé.";
    }
    $conn->close();
}
?>
