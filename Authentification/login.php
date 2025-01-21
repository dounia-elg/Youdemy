<?php
session_start();  

require_once '../connect.php';
require_once '../classe_utilisateur.php'; 
require_once '../Admin/classe_admin.php'; 
require_once '../Enseignant/classe_enseignant.php'; 
require_once '../Etudiant/classe_etudiant.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['role'] == 'admin') {
            $userObj = new Admin($user['nom'], $user['email'], $password); 
        } elseif ($user['role'] == 'enseignant') {
            $userObj = new Enseignant($user['nom'], $user['email'], $password); 
        } elseif ($user['role'] == 'etudiant') {
            $userObj = new Etudiant($user['nom'], $user['email'], $password); 
        } else {
            echo "Unknown role.";
            exit();
        }

        if ($userObj->login($conn)) {
            // Stocker les informations dans la session
            $_SESSION['role'] = $user['role'];
            $_SESSION['id_user'] = $user['id']; // ID de l'utilisateur
            $_SESSION['email'] = $user['email']; // Email de l'utilisateur
            $_SESSION['id_enseignant'] = ($user['role'] == 'enseignant') ? $user['id'] : null; // ID de l'enseignant

            // Rediriger selon le rôle
            if ($_SESSION['role'] == 'admin') {
                header('Location: /Admin/Espace_Admin.php');
            } elseif ($_SESSION['role'] == 'enseignant') {
                header('Location: /Enseignant/Espace_Enseignant.php');
            } elseif ($_SESSION['role'] == 'etudiant') {
                header('Location: /Etudiant/Espace_Etudiant.php');
            }
            exit();
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "User not found!";
    }
}
?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Connexion</h2>
        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <button type="submit" 
                class="w-full py-2 px-4 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Se connecter
            </button>
        </form>
    </div>
</body>
</html>
