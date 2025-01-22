<?php
require_once '../connect.php'; 
require_once '../Cours/ClasseCours.php'; 

$error = null;
$cours = null;
$categories = [];


$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$categories = Cours::getCategories($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idCours = $_GET['id'];
    $cours = Cours::getCoursById($conn, $idCours); 
    if (!$cours) {
        $error = "Cours introuvable.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCours = $_POST['id_cour'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $contenu = $_POST['contenu'];
    $idCategorie = $_POST['id_categorie'];

    $cours = Cours::getCoursById($conn, $idCours);
    if ($cours) {
        
        $cours->setTitre($titre);
        $cours->setDescription($description);
        $cours->setContenu($contenu);
        $cours->setIdCategorie($idCategorie);

        
        if ($cours->modifierCours()) {
            header('Location: ../Enseignant/Espace_Enseignant.php?success=1');
            exit;
        } else {
            $error = "Erreur lors de la mise à jour du cours.";
        }
    } else {
        $error = "Cours introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier le Cours</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navigation Bar -->
  <header class="bg-white text-black py-4">
    <div class="container mx-auto flex justify-between items-center px-6">
      <h1 class="text-2xl font-bold text-blue-700">Modifier le Cours</h1>
      <nav>
        <a href="../Enseignant/Espace_Enseignant.php" class="mx-4 hover:underline">Retour à l'espace enseignant</a>
      </nav>
    </div>
  </header>

  <!-- Formulaire de modification -->
  <main class="container mx-auto p-6">
    <?php if ($error): ?>
      <div class="text-red-500 text-center mb-6"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($cours): ?>
      <h2 class="text-3xl font-bold text-center mb-6 text-indigo-600">Modifier le cours : <?= htmlspecialchars($cours->getTitre()) ?></h2>
      
      <form method="POST" action="modifierCours.php" class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        
        <!-- Cacher l'ID du cours -->
        <input type="hidden" name="id_cour" value="<?= $cours->getId() ?>">

        <!-- Titre -->
        <div class="mb-6">
          <label for="titre" class="block text-gray-700 text-lg font-semibold mb-2">Titre du cours</label>
          <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($cours->getTitre()) ?>" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Description -->
        <div class="mb-6">
          <label for="description" class="block text-gray-700 text-lg font-semibold mb-2">Description</label>
          <textarea id="description" name="description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($cours->getDescription()) ?></textarea>
        </div>

        <!-- Contenu -->
        <div class="mb-6">
          <label for="contenu" class="block text-gray-700 text-lg font-semibold mb-2">Contenu</label>
          <textarea id="contenu" name="contenu" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($cours->getContenu()) ?></textarea>
        </div>

        <!-- Catégorie -->
        <div class="mb-6">
          <label for="categorie" class="block text-gray-700 text-lg font-semibold mb-2">Catégorie</label>
          <select id="categorie" name="id_categorie" required
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
            <?php foreach ($categories as $categorie): ?>
              <option value="<?= htmlspecialchars($categorie['id_categorie']) ?>" 
                      <?= $categorie['id_categorie'] == $cours->getIdCategorie() ? 'selected' : '' ?>>
                <?= htmlspecialchars($categorie['nom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end space-x-4">
          <button type="submit" class="px-6 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">Enregistrer</button>
          <a href="../Enseignant/Espace_Enseignant.php" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Annuler</a>
        </div>

      </form>
    <?php endif; ?>
  </main>

</body>
</html>
