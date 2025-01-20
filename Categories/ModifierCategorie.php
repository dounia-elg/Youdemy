<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Catégorie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Modifier une Catégorie</h2>
        <form action="modifier_categorie.php?id=<?php echo $id_categorie; ?>" method="POST" class="space-y-4">
            <div>
                <label for="nom_categorie" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
                <input type="text" id="nom_categorie" name="nom_categorie" value="<?php echo htmlspecialchars($nom_categorie); ?>" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>


            <button type="submit" 
                class="w-full py-2 px-4 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Mettre à jour la catégorie
            </button>
        </form>
    </div>
</body>
</html>