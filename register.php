<?php
// Connexion à la base de données MySQL
global $pdo;
require_once ('db.php');
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password =htmlspecialchars( $_POST['password']);

    // Vérifier si l'utilisateur existe déjà
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $pdo->query($sql);
    if ($result > 0) {
        echo "Nom d'utilisateur ou email déjà utilisés.";
    } else {
        // Hacher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Définir le rôle par défaut à 'user'
        $role = 'user';

        // Insérer le nouvel utilisateur dans la base de données avec un rôle par défaut
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";
        
        if ($pdo->query($sql) === TRUE) {
            echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            echo "Erreur : " . $sql . "<br>";
        }
    }

}
?>
