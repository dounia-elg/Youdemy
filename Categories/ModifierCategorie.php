<?php
require '../connect.php'; 
require '../Categories/ClasseCategories.php'; 

$idCategorie = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idCategorie <= 0) {
    die("ID de catégorie invalide.");
}

$nomCategorie = '';

$categories = new Categories($conn);

$categories->setId($idCategorie);
$categorieActuelle = $categories->listeCategories(); 

foreach ($categorieActuelle as $categorie) {
    if ($categorie['id_categorie'] == $idCategorie) {
        $nomCategorie = $categorie['nom'];
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomCategorie = htmlspecialchars($_POST['nom_categorie'], ENT_QUOTES, 'UTF-8');

    if (!empty($nomCategorie)) {
        $categories->setNom($nomCategorie);

        if ($categories->modifierCategorie()) {
            header('Location: ../Admin/Espace_Admin.php');
            exit();
        } else {
            echo "<p style='color: red;'>Erreur lors de la mise à jour.</p>";
        }
    } else {
        echo "<p style='color: red;'>Le nom de la catégorie ne peut pas être vide.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Catégorie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Modifier une Catégorie</h2>
        <form action="../Categories/ModifierCategorie.php?id=<?php echo $idCategorie; ?>" method="POST">
            <div>
                <label for="nom_categorie" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
                <input type="text" id="nom_categorie" name="nom_categorie" 
                       value="<?php echo htmlspecialchars($nomCategorie, ENT_QUOTES, 'UTF-8'); ?>" 
                       required 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <button type="submit" 
                class="w-full py-2 px-4 mt-4 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Mettre à jour
            </button>
        </form>
    </div>
</body>
</html>
