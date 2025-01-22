<?php
require_once '../Cours/ClasseCours.php'; 
require_once '../connect.php'; 
session_start();

$idEtudiant = isset( $_SESSION['id_user']) ?  $_SESSION['id_user'] : null;


$stmt = $conn->prepare("
   SELECT c.id_cour, c.titre, c.description
FROM cours c
JOIN inscription i ON i.id_cours = c.id_cour
JOIN utilisateur u ON u.id = i.id_etudiant
WHERE u.id = :id_user;

");
$stmt->bindParam(':id_user', $idEtudiant, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; 
$offset = ($page - 1) * $limit;

$totalCours = $conn->query("SELECT COUNT(*) FROM cours")->fetchColumn();
$totalPages = ceil($totalCours / $limit);
?>

<!DOCTYPE html>
<html lang="fr">
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
        <a href="../Etudiant/Espace_Etudiant.php" class="mx-4 hover:underline">Catalogue</a>
        <a href="/../index.php" class="mx-4 hover:underline">Accueil</a>
        <a href="#my-courses" class="mx-4 hover:underline">Mes cours</a>
        <a href="../Authentification/logout.php" class="w-full py-2 px-4 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Se déconnecter</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto p-6">

    <!-- Mes cours -->
    <section id="my-courses" class="my-12">
      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Mes cours</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (!empty($courses)): ?>
          <?php foreach ($courses as $course): ?>
            <div class="bg-white rounded-lg shadow-md p-4">
              <h3 class="text-xl font-bold text-gray-700"><?= htmlspecialchars($course['titre']) ?></h3>
              <p class="text-gray-600"><?= htmlspecialchars($course['description']) ?></p>
              <div class="mt-4">
                <button class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 w-full"><a href="../Etudiant/desinscrire.php?id_cours=<?php echo $course['id_cour']; ?>">désinscrire</a></button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-gray-700">Vous n'êtes inscrit à aucun cours pour le moment.</p>
        <?php endif; ?>
      </div>
    </section>

    <!-- Pagination -->
    <div class="mt-8 text-center">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="px-4 py-2 mx-1 rounded <?= $i == $page ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
    </div>

  </main>

  

</body>
</html>
