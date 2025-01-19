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
        <a href="#my-courses" class="mx-4 hover:underline">Mes cours</a>
        <a href="#profile" class="mx-4 hover:underline">Profil</a>
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
    <section id="courses" class="my-12">
      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Catalogue des cours</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Card for a course -->
        <div class="bg-white rounded-lg shadow-md p-4">
          <h3 class="text-xl font-bold text-gray-700">Développement Web</h3>
          <p class="text-gray-600">Enseignant : John Doe</p>
          <p class="text-gray-600">Catégorie : Programmation</p>
          <div class="mt-4 flex justify-between items-center">
            <button class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">Détails</button>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">S'inscrire</button>
          </div>
        </div>
        
      </div>
    </section>

    <!-- Mes cours -->
    <section id="my-courses" class="my-12">
      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Mes cours</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Card for a student's course -->
        <div class="bg-white rounded-lg shadow-md p-4">
          <h3 class="text-xl font-bold text-gray-700">Développement Web</h3>
          <p class="text-gray-600">Enseignant : John Doe</p>
          <p class="text-gray-600">Progression : 50%</p>
          <div class="mt-4">
            <button class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 w-full">Continuer</button>
          </div>
        </div>
        <!-- Répétez pour d'autres cours -->
      </div>
    </section>

    <!-- Profil étudiant -->
    <section id="profile" class="my-12">
      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Mon profil</h2>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <p class="text-gray-700 font-bold">Nom : <span class="font-normal">Jane Doe</span></p>
        <p class="text-gray-700 font-bold">Email : <span class="font-normal">jane.doe@example.com</span></p>
        <p class="text-gray-700 font-bold">Cours suivis : <span class="font-normal">5</span></p>
        <div class="mt-4">
          <button class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Se déconnecter</button>
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
