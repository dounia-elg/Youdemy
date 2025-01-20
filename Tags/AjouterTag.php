<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Tag</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Ajouter un Tag</h2>
        <form action="ajouter_tag.php" method="POST" class="space-y-4">
            <div>
                <label for="tag_nom" class="block text-sm font-medium text-gray-700">Nom du Tag</label>
                <input type="text" id="tag_nom" name="tag_nom" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <button type="submit" 
                class="w-full py-2 px-4 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Ajouter le Tag
            </button>
        </form>
    </div>
</body>
</html>
