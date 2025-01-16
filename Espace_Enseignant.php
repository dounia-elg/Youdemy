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
        <a href="#add-course" class="mx-4 hover:underline">Ajouter un cours</a>
        <a href="#manage-courses" class="mx-4 hover:underline">Mes cours</a>
        <a href="#statistics" class="mx-4 hover:underline">Statistiques</a>
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
        <a href="#add-course" class="px-6 py-3 bg-white text-teal-500 font-bold rounded-lg hover:bg-gray-200">Commencer maintenant</a>
      </div>
      <div class="md:w-1/2 mt-6 md:mt-0">
        <img src="/teacher.jpg" alt="Espace Enseignant" class="rounded-lg shadow-lg mx-auto">
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <main class="container mx-auto p-6">

    <!-- Ajouter un cours -->
    <section id="add-course" class="my-12">
      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Ajouter un nouveau cours</h2>
      <form class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Titre du cours</label>
          <input type="text" class="w-full border-gray-300 rounded-lg p-2" placeholder="Exemple : Développement Web">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Description</label>
          <textarea class="w-full border-gray-300 rounded-lg p-2" rows="4" placeholder="Décrivez brièvement le contenu du cours"></textarea>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Catégorie</label>
          <select class="w-full border-gray-300 rounded-lg p-2">
            <option>Programmation</option>
            <option>Marketing</option>
            <option>Design</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Tags (séparés par une virgule)</label>
          <input type="text" class="w-full border-gray-300 rounded-lg p-2" placeholder="Exemple : JavaScript, Frontend">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Contenu du cours</label>
          <input type="file" class="w-full border-gray-300 rounded-lg p-2">
        </div>
        <button class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">Ajouter</button>
      </form>
    </section>

    <!-- Gestion des cours -->
    <section id="manage-courses" class="my-12">
      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Mes cours</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-md p-4">
          <h3 class="text-xl font-bold text-gray-700">Développement Web</h3>
          <p class="text-gray-600">Catégorie : Programmation</p>
          <p class="text-gray-600">Étudiants inscrits : 50</p>
          <div class="mt-4 flex justify-between">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Modifier</button>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Supprimer</button>
          </div>
        </div>
        <!-- Répétez pour d'autres cours -->
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
