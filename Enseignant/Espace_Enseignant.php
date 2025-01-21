<?php
session_start();
require_once '../connect.php';  
require_once '../Cours/ClasseCours.php';  

if (!isset($_SESSION['id_enseignant'])) {
    header("Location: /Authentification/login.php");
    exit();
}

$enseignant_id = $_SESSION['id_enseignant']; 

$cours = Cours::getCoursByEnseignant($conn, $enseignant_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy - Enseignant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navigation Bar -->
  <header class="bg-white text-black py-4">
    <div class="container mx-auto flex justify-between items-center px-6">
      <h1 class="text-2xl font-bold text-blue-700">Youdemy - Espace Enseignant</h1>
      <nav>
        <a href="../Cours/ajouterCours.php" class="mx-4 hover:underline">Ajouter un cours</a>
        <a href="#manage-courses" class="mx-4 hover:underline">Mes cours</a>
        <a href="#statistics" class="mx-4 hover:underline">Statistiques</a>
        <a href="../Authentification/logout.php" class="w-full py-2 px-4 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Se déconnecter</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-teal-500 to-indigo-600 text-white py-20">
    <div class="container mx-auto flex flex-col md:flex-row items-center">
      <div class="md:w-1/2 text-center md:text-left">
        <h2 class="text-4xl font-bold mb-4">Créez et gérez vos cours en un clic</h2>
        <p class="text-lg mb-6">
          Bienvenue dans votre espace enseignant. Ajoutez de nouveaux cours, gérez vos contenus et suivez les statistiques d'apprentissage.
        </p>
        <a href="../Cours/ajouterCours.php" class="px-6 py-3 bg-white text-teal-500 font-bold rounded-lg hover:bg-gray-200">Ajouter un cours</a>
      </div>
      <div class="md:w-1/2 mt-6 md:mt-0">
        <img src="/img/teacher.jpg" alt="Espace Enseignant" class="rounded-lg shadow-lg mx-auto">
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <main class="container mx-auto p-6">

    <!-- Gestion mes cours -->
    <section id="courses" class="py-16 bg-gray-50">
    <div class="container mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Mes Cours</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if ($cours): ?>
                <?php foreach ($cours as $cour): ?>
                    <div class="rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6 bg-white">
                            <!-- Titre du cours -->
                            <h3 class="text-2xl font-bold text-indigo-600 mb-4"><?= htmlspecialchars($cour['titre']) ?></h3>
                            <!-- Description -->
                            <p class="text-gray-700 mb-4"><?= htmlspecialchars($cour['description']) ?></p>
                            <!-- Contenu -->
                            <div class="mb-4">
                                <?php if (filter_var($cour['contenu'], FILTER_VALIDATE_URL) && strpos($cour['contenu'], 'youtube.com') !== false): ?>
                                    <!-- Contenu vidéo -->
                                    <iframe 
                                        width="100%" 
                                        height="200" 
                                        src="<?= htmlspecialchars(str_replace('watch?v=', 'embed/', $cour['contenu'])) ?>" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                <?php else: ?>
                                    <!-- Contenu texte -->
                                    <p class="text-gray-500"><?= htmlspecialchars($cour['contenu']) ?></p>
                                <?php endif; ?>
                            </div>
                            <!-- Catégorie -->
                            <p class="text-gray-500">Catégorie : <?= htmlspecialchars($cour['categorie_nom']) ?></p>
                            <!-- Enseignant -->
                            <p class="text-gray-500">Enseignant : <?= htmlspecialchars($cour['enseignant_nom']) ?></p>
                            <!-- Lien vers le détail -->
                            <a href="../Cours/detailCours.php?id=<?= $cour['id_cour'] ?>" 
                               class="text-indigo-600 font-semibold hover:underline">Voir le cours →</a>

                            <!-- Boutons Modifier et Supprimer -->
                            <div class="mt-4 flex space-x-4">
                                <a href="../Cours/modifierCours.php?id=<?= $cour['id_cour'] ?>" 
                                   class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Modifier</a>
                                <a href="../Cours/supprimerCours.php?id=<?= $cour['id_cour'] ?>" 
                                   class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">Supprimer</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="col-span-3 text-center text-gray-700">Aucun cours ajouté pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>





    <!-- Statistiques -->
    <section id="statistics" class="my-12">
      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Statistiques</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-bold text-gray-700">Nombre total de cours</h3>
          <p class="text-4xl font-bold text-teal-500 mt-4">5</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-bold text-gray-700">Nombre total d'étudiants inscrits</h3>
          <p class="text-4xl font-bold text-teal-500 mt-4">150</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-bold text-gray-700">Top catégorie</h3>
          <p class="text-4xl font-bold text-teal-500 mt-4">Programmation</p>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4">
    <div class="container mx-auto text-center">
      <p>© 2025 Youdemy. Tous droits réservés.</p>
    </div>
  </footer>

</body>
</html>
