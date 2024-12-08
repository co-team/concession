<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <style>
        /* Styles de base */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f9;
        }

        /* Conteneur du formulaire */
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Titre */
        h2 {
            color: #5A67D8;
            margin-bottom: 20px;
        }

        /* Champs de saisie */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Bouton de connexion */
        button {
            width: 100%;
            padding: 12px;
            background-color: #5A67D8;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #434190;
        }

        /* Lien de réinitialisation */
        .reset-link {
            display: block;
            margin-top: 15px;
            color: #5A67D8;
            text-decoration: none;
            font-size: 14px;
        }

        .reset-link:hover {
            color: #434190;
        }

        /* Message d'erreur */
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Connexion</h2>
        
        <!-- Formulaire de connexion -->
        <form id="loginForm" onsubmit="return validateForm()" action="login.php">
            <input type="text" id="username" placeholder="Nom d'utilisateur" required>
            <input type="password" id="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
            <p class="error-message" id="errorMessage">Nom d'utilisateur ou mot de passe incorrect.</p>
            <a href="#" class="reset-link">Mot de passe oublié ?</a>
        </form>
    </div>

    <script>
        // Fonction de validation du formulaire
        function validateForm() {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            const errorMessage = document.getElementById("errorMessage");

            // Exemple simple de validation
            if (username === "admin" && password === "password") {
                alert("Connexion réussie !");
                return true; // Redirige ou traite le formulaire
            } else {
                errorMessage.style.display = "block"; // Affiche le message d'erreur
                return false; // Empêche la soumission du formulaire
            }
        }
    </script>

</body>
</html>
