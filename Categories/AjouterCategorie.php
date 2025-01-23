<?php
require_once '../connect.php';
require_once 'ClasseCategories.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom'];

    $categorie = new Categories($conn, $nom);

    if ($categorie->ajouterCategorie()) {
        
        header("Location: ../Admin/Espace_Admin.php?success=1");
        exit; 
    } else {
        
        $errorMessage = "Erreur lors de l'ajout de la catégorie.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Catégorie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Ajouter une Catégorie</h1>
        <?php if (!empty($errorMessage)): ?>
            <p class="text-red-600 mb-4"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
        <form action="AjouterCategorie.php" method="POST">
            <div class="mb-4">
                <label for="nom" class="block font-bold mb-2">Nom de la catégorie :</label>
                <input type="text" id="nom" name="nom" class="w-full px-4 py-2 border rounded" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ajouter</button>
        </form>
    </div>
</body>
</html>
