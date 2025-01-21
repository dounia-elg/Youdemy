<?php
session_start();
require_once '../connect.php';
require_once '../Cours/ClasseCours.php';

if (!isset($_SESSION['id_enseignant'])) {
    header('Location: /Authentification/login.php');
    exit();
}

$id_enseignant = $_SESSION['id_enseignant'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $contenu = $_POST['contenu'];
    $idCategorie = $_POST['categorie']; 

    $cours = new Cours($conn, $titre, $description, $contenu, $idCategorie, $id_enseignant);

    if ($cours->ajouterCours()) {
        echo "Cours ajouté avec succès !";
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un Cours</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
      <h1 class="text-2xl font-bold mb-6 text-blue-600">Ajouter un Nouveau Cours</h1>
      <form action="../Cours/ajouterCours.php" method="POST">
        <!-- Titre -->
        <div class="mb-4">
          <label for="titre" class="block text-gray-700 font-medium mb-2">Titre du cours</label>
          <input type="text" id="titre" name="titre" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" placeholder="Titre du cours" required>
        </div>

        <!-- Description -->
        <div class="mb-4">
          <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
          <textarea id="description" name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" placeholder="Description du cours" required></textarea>
        </div>

        <!-- Contenu -->
        <div class="mb-4">
          <label for="contenu" class="block text-gray-700 font-medium mb-2">Contenu</label>
          <textarea id="contenu" name="contenu" rows="6" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" placeholder="Contenu du cours (lien vidéo, texte, etc.)" required></textarea>
        </div>

        <!-- Catégorie -->
        <div class="mb-4">
          <label for="categorie" class="block text-gray-700 font-medium mb-2">Catégorie</label>
          <select id="categorie" name="categorie" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" required>
            <?php
            require_once '../connect.php';

            try {
                $stmt = $conn->query("SELECT id_categorie, nom FROM categories");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$row['id_categorie']}\">{$row['nom']}</option>";
                }
            } catch (Exception $e) {
                echo "<option value=\"\">Erreur lors du chargement des catégories</option>";
            }
            ?>
          </select>
        </div>

        <!-- Bouton Ajouter -->
        <div class="mt-6">
          <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg shadow-sm hover:bg-blue-700 focus:ring focus:ring-blue-300">Ajouter le cours</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
