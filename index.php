<?php
require_once 'Cours/ClasseCours.php'; 
require_once 'connect.php'; 
session_start();  
$idEtudiant = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;



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
  <title>Youdemy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .hero-overlay {
      background: linear-gradient(to bottom right, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7));
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <a href="/index.php" class="text-3xl font-bold text-indigo-600">Youdemy</a>
      <nav class="space-x-6">
        <a href="/index.php" class="text-gray-600 hover:text-indigo-600">Accueil</a>
        <a href="/Etudiant/Espace_Etudiant.php" class="mx-4 hover:underline">Catalogue</a>

        
        <!-- Vérification si l'étudiant est connecté -->
        <?php if ($idEtudiant): ?>
          <!-- Si l'étudiant est connecté -->
          <a href="../Etudiant/myCourses.php" class="mx-4 hover:underline">Mes cours</a>
          <a href="#profile" class="mx-4 hover:underline">Profil</a>
          <a href="../Authentification/logout.php" class="w-full py-2 px-4 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Se déconnecter</a>
        <?php else: ?>
          <!-- Si l'étudiant n'est pas connecté -->
          <a href="../Authentification/login.php" class="text-gray-600 hover:text-indigo-600">Connexion</a>
          <a href="../Authentification/signup.php" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700">Inscription</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="relative h-screen bg-cover bg-center" style="background-image: url('/img/hero.jpg');">
    <div class="hero-overlay absolute inset-0"></div>
    <div class="relative text-center text-white flex flex-col justify-center h-full px-6">
      <h1 class="text-5xl md:text-6xl font-bold mb-6">Votre avenir commence ici avec <span class="text-yellow-300">Youdemy</span></h1>
      <p class="text-lg md:text-xl mb-8">Apprenez, enseignez et inspirez grâce à notre plateforme d'apprentissage en ligne.</p>
      <div class="flex justify-center space-x-4">
        <a href="#courses" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-lg text-white font-medium">Explorer les cours</a>
        <a href="#" class="px-6 py-3 bg-yellow-300 hover:bg-yellow-400 rounded-lg shadow-lg text-gray-900 font-medium">Devenir enseignant</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-16 bg-gray-100">
    <div class="container mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Pourquoi choisir Youdemy ?</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 rounded-lg shadow-lg bg-white">
          <img src="/img/formation.jpg" alt="Formation Complète" class="w-full h-48 object-cover mb-4">
          <h3 class="text-xl font-bold text-blue-600 mb-4">Formation Complète</h3>
          <p class="text-gray-700">Des cours pour tous les niveaux, du débutant à l'expert.</p>
        </div>
        <div class="p-6 rounded-lg shadow-lg bg-white">
          <img src="/img/community.jpg" alt="Communauté Active" class="w-full h-48 object-cover mb-4">
          <h3 class="text-xl font-bold text-green-600 mb-4">Communauté Active</h3>
          <p class="text-gray-700">Échangez avec des étudiants et enseignants passionnés.</p>
        </div>
        <div class="p-6 rounded-lg shadow-lg bg-white">
          <img src="/img/suivi.jpg" alt="Suivi Personnalisé" class="w-full h-48 object-cover mb-4">
          <h3 class="text-xl font-bold text-purple-600 mb-4">Suivi Personnalisé</h3>
          <p class="text-gray-700">Progressez avec des statistiques détaillées et des retours.</p>
        </div>
      </div>
    </div>
  </section>


  <section id="courses" class="py-16">
    <div class="container mx-auto">
      <h2 class="text-3xl font-bold mb-8">Courses</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($coursList as $cours): ?>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($cours['titre']); ?></h3>
            <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($cours['description']); ?></p>
            <?php if ($idEtudiant): ?>
              <?php
              $stmt = $conn->prepare("SELECT COUNT(*) FROM inscription WHERE id_etudiant = :id_etudiant AND id_cours = :id_cour");
              $stmt->execute([':id_etudiant' => $idEtudiant, ':id_cour' => $cours['id_cour']]);
              $isEnrolled = $stmt->fetchColumn() > 0;
              ?>
              <?php if ($isEnrolled): ?>
                <a class="py-2 px-4 bg-gray-500 text-white rounded-md shadow-md cursor-not-allowed" href="<?php echo 'Cours/detailCours.php?id_cours=' . $cours['id_cour']; ?>">Watch now</a>
              <?php else: ?>
                <form method="post" action="/Etudiant/inscription.php">
                  <input type="hidden" name="id_cours" value="<?php echo $cours['id_cour']; ?>">
                  <button type="submit" class="py-2 px-4 bg-teal-500 text-white rounded-md shadow-md hover:bg-teasl-600">Enroll Now</button>
                </form>
              <?php endif; ?>
            <?php else: ?>
              <a href="Authentification/login.php" class="py-2 px-4 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600">Login to Enroll</a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <div class="mt-8">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="?page=<?php echo $i; ?>" class="py-2 px-4 bg-gray-200 text-gray-700 rounded-md shadow-md hover:bg-gray-300 <?php echo $i == $page ? 'bg-gray-400' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 py-6">
    <div class="container mx-auto text-center">
      <p>&copy; 2025 Youdemy. Tous droits réservés.</p>
    </div>
  </footer>

</body>
</html>
