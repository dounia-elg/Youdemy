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
        <a href="#courses" class="text-gray-600 hover:text-indigo-600">Catalogue</a>
        <a href="/Authentification/login.php" class="text-gray-600 hover:text-indigo-600">Connexion</a>
        <a href="/Authentification/signup.php" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700">Inscription</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="relative h-screen bg-cover bg-center" style="background-image: url('/hero.jpg');">
    <div class="hero-overlay absolute inset-0"></div>
    <div class="relative text-center text-white flex flex-col justify-center h-full px-6">
      <h1 class="text-5xl md:text-6xl font-bold mb-6">
        Votre avenir commence ici avec <span class="text-yellow-300">Youdemy</span>
      </h1>
      <p class="text-lg md:text-xl mb-8">
        Apprenez, enseignez et inspirez grâce à notre plateforme d'apprentissage en ligne.
      </p>
      <div class="flex justify-center space-x-4">
        <a href="#courses" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-lg text-white font-medium">
          Explorer les cours
        </a>
        <a href="#" class="px-6 py-3 bg-yellow-300 hover:bg-yellow-400 rounded-lg shadow-lg text-gray-900 font-medium">
          Devenir enseignant
        </a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-16 bg-gray-100">
    <div class="container mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Pourquoi choisir Youdemy ?</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 rounded-lg shadow-lg bg-white">
          <img src="/formation.jpg" alt="Formation Complète" class="w-full h-48 object-cover mb-4">
          <h3 class="text-xl font-bold text-blue-600 mb-4">Formation Complète</h3>
          <p class="text-gray-700">
            Des cours pour tous les niveaux, du débutant à l'expert.
          </p>
        </div>
        <div class="p-6 rounded-lg shadow-lg bg-white">
          <img src="/community.jpg" alt="Communauté Active" class="w-full h-48 object-cover mb-4">
          <h3 class="text-xl font-bold text-green-600 mb-4">Communauté Active</h3>
          <p class="text-gray-700">
            Échangez avec des étudiants et enseignants passionnés.
          </p>
        </div>
        <div class="p-6 rounded-lg shadow-lg bg-white">
          <img src="/suivi.jpg" alt="Suivi Personnalisé" class="w-full h-48 object-cover mb-4">
          <h3 class="text-xl font-bold text-purple-600 mb-4">Suivi Personnalisé</h3>
          <p class="text-gray-700">
            Progressez avec des statistiques détaillées et des retours.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Courses Section -->
  <section id="courses" class="py-16 bg-gray-50">
    <div class="container mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Catalogue des Cours</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div class="rounded-lg shadow-lg overflow-hidden">
          <img src="https://via.placeholder.com/400x300" alt="Développement Web" class="w-full h-48 object-cover">
          <div class="p-6 bg-white">
            <h3 class="text-2xl font-bold text-indigo-600 mb-4">Développement Web</h3>
            <p class="text-gray-700 mb-4">
              Apprenez les bases du développement web avec HTML, CSS et JavaScript.
            </p>
            <a href="#" class="text-indigo-600 font-semibold hover:underline">Voir le cours &rarr;</a>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="rounded-lg shadow-lg overflow-hidden">
          <img src="https://via.placeholder.com/400x300" alt="Design Graphique" class="w-full h-48 object-cover">
          <div class="p-6 bg-white">
            <h3 class="text-2xl font-bold text-green-600 mb-4">Design Graphique</h3>
            <p class="text-gray-700 mb-4">
              Explorez les outils de création comme Photoshop et Illustrator.
            </p>
            <a href="#" class="text-green-600 font-semibold hover:underline">Voir le cours &rarr;</a>
          </div>
        </div>
        <!-- Card 3 -->
        <div class="rounded-lg shadow-lg overflow-hidden">
          <img src="https://via.placeholder.com/400x300" alt="Analyse de Données" class="w-full h-48 object-cover">
          <div class="p-6 bg-white">
            <h3 class="text-2xl font-bold text-purple-600 mb-4">Analyse de Données</h3>
            <p class="text-gray-700 mb-4">
              Maîtrisez les outils d'analyse de données avec Python et Excel.
            </p>
            <a href="#" class="text-purple-600 font-semibold hover:underline">Voir le cours &rarr;</a>
          </div>
        </div>
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
