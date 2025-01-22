<?php
require_once '../Cours/ClasseCours.php'; 
require_once '../connect.php'; 
session_start();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; 
$offset = ($page - 1) * $limit;

$stmt = $conn->prepare("SELECT * FROM cours LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$coursList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalCours = $conn->query("SELECT COUNT(*) FROM cours")->fetchColumn();
$totalPages = ceil($totalCours / $limit);
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy - Espace Étudiant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navigation Bar -->
  <header class="bg-white text-black py-4">
    <div class="container mx-auto flex justify-between items-center px-6">
      <h1 class="text-2xl font-bold text-blue-700">Youdemy - Espace Étudiant</h1>
      <nav>
        <a href="#courses" class="mx-4 hover:underline">Catalogue</a>
        <a href="/../index.php" class="mx-4 hover:underline">Acceuil</a>

        <a href="../Etudiant/myCourses.php" class="mx-4 hover:underline">Mes cours</a>
        <a href="#profile" class="mx-4 hover:underline">Profil</a>
        <a href="../Authentification/logout.php"  class="w-full py-2 px-4 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Se déconnecter</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-teal-500 to-indigo-600 text-white py-20">
    <div class="container mx-auto flex flex-col md:flex-row items-center">
      <div class="md:w-1/2 text-center md:text-left">
        <h2 class="text-4xl font-bold mb-4">Apprenez à votre rythme</h2>
        <p class="text-lg mb-6">
          Découvrez des cours interactifs et enrichissants, inscrivez-vous et commencez votre parcours d’apprentissage dès maintenant.
        </p>
        <a href="#courses" class="px-6 py-3 bg-white text-teal-500 font-bold rounded-lg hover:bg-gray-200">Explorer les cours</a>
      </div>
      <div class="md:w-1/2 mt-6 md:mt-0">
        <img src="/img/etudiant.jpg" alt="Espace Étudiant" class="rounded-lg shadow-lg mx-auto">
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <main class="container mx-auto p-6">

    <!-- Catalogue des cours -->
    <section id="courses" class="py-16 bg-gray-50">
  <div class="container mx-auto">
    <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Catalogue des Cours</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php if (!empty($coursList)): ?>
        <?php foreach ($coursList as $course): ?>

          <div class="p-6 rounded-lg shadow-lg bg-white">
            <h3 class="text-xl font-bold text-indigo-600 mb-4"><?= htmlspecialchars($course['titre']) ?></h3>
            <p class="text-gray-700 mb-4"><?= htmlspecialchars($course['description']) ?></p>
            <!-- Bouton S'inscrire -->
            <form action="/Etudiant/inscription.php" method="post">
              <input type="hidden" name="id_cour" value="<?= $course['id_cour'] ?>">
              <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700">
              <a href="/Etudiant/inscription.php?id_cours=<?php echo $course['id_cour']; ?>">S'inscrire</a>
              </button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-700">Aucun cours disponible.</p>
      <?php endif; ?>
    </div>

    <div class="mt-8 text-center">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="px-4 py-2 mx-1 rounded <?= $i == $page ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
    </div>
  </div>
</section>

  


    

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4">
    <div class="container mx-auto text-center">
      <p>© 2025 Youdemy. Tous droits réservés.</p>
    </div>
  </footer>

</body>
</html>
