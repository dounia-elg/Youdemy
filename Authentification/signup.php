<?php
require_once '../connect.php'; 
require_once '../Etudiant/classe_etudiant.php'; 
require_once '../Enseignant/classe_enseignant.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email is not valid.";
        exit;
    }

    if ($role === 'etudiant') {
        $user = new Etudiant($nom, $email, $password);
    } elseif ($role === 'enseignant') {
        $user = new Enseignant($nom, $email, $password);
    } else {
        echo "Invalid role selected.";
        exit;
    }

    $user->signup($conn);

    header('Location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Inscription</h2>
        <form action="/Authentification/signup.php" method="POST" class="space-y-4">
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" id="nom" name="nom" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
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
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select id="role" name="role" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="etudiant">Étudiant</option>
                    <option value="enseignant">Enseignant</option>
                </select>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">S'inscrire</button>
        </form>
    </div>
</body>
</html>
