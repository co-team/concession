<?php
global $pdo;
session_start();

require_once ('../db.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']) ;
    $password = htmlspecialchars($_POST['password']);

    // Vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $pdo->query($sql);
    
    if ($result->rowCount() > 0) {
        $user = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            // Connexion réussie, initialiser la session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirection selon le rôle de l'utilisateur
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");  // Tableau de bord administrateur
            } else {
                header("Location: user_dashboard.php");   // Tableau de bord utilisateur
            }
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }

}
?>
