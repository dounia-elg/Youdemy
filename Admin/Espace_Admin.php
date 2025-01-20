<?php
require_once '../connect.php';
require_once '../Enseignant/classe_enseignant.php';
require_once '../Admin/classe_admin.php';
require_once '../Categories/ClasseCategories.php';


$admin = new Admin('Admin', 'admin@gmail.com', 'password');


try {
    $stmt = $conn->prepare("SELECT id, nom, email FROM utilisateur WHERE role = 'enseignant' AND est_valide = 0");
    $stmt->execute();
    $pendingTeachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erreur lors de la récupération des enseignants : " . $e->getMessage();
    $pendingTeachers = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valider'], $_POST['enseignant_id'])) {
    $enseignantId = (int) $_POST['enseignant_id'];

    try {
        $admin->ValiderComptesEnseignants($conn, $enseignantId);
        header("Location: Espace_Admin.php?success=1");
        exit;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}


$categorie = new Categories($conn);
$categories = $categorie->listeCategories();

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Sidebar -->
  <aside class="w-64 h-screen bg-indigo-600 text-white fixed">
    <div class="py-4 px-6 text-xl font-bold">Youdemy Admin</div>
    <nav>
      <a href="#validate-teachers" class="block py-2 px-4 hover:bg-indigo-700">Validation des enseignants</a>
      <a href="#users-management" class="block py-2 px-4 hover:bg-indigo-700">Gestion des utilisateurs</a>
      <a href="#courses-management" class="block py-2 px-4 hover:bg-indigo-700">Gestion des cours</a>
      <a href="#categories-tags" class="block py-2 px-4 hover:bg-indigo-700">Catégories & Tags</a>
      <a href="#stats" class="block py-2 px-4 hover:bg-indigo-700">Statistiques globales</a>
      <a href="../Authentification/logout.php"  class="block py-2 px-4 hover:bg-indigo-700">Se déconnecter</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="ml-64 p-8">
    <h1 class="text-3xl font-bold mb-8">Dashboard Administrateur</h1>

    <!-- Validation des enseignants -->
    <section id="validate-teachers" class="mb-16">

        <h2 class="text-2xl font-bold mb-4">Validation des enseignants</h2>
        <table class="w-full bg-white shadow rounded-lg">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pendingTeachers)): ?>
                    <?php foreach ($pendingTeachers as $teacher): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= htmlspecialchars($teacher['nom']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($teacher['email']) ?></td>
                            <td class="px-4 py-2">
                                <form method="POST" action="">
                                    <input type="hidden" name="enseignant_id" value="<?= $teacher['id'] ?>">
                                    <button type="submit" name="valider" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Valider</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center">Aucun enseignant en attente de validation.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>


    <!-- Gestion des utilisateurs -->
    <section id="users-management" class="mb-16">
      <h2 class="text-2xl font-bold mb-4">Gestion des utilisateurs</h2>
      <table class="w-full bg-white shadow rounded-lg">
        <thead class="bg-indigo-600 text-white">
          <tr>
            <th class="px-4 py-2">Nom</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Rôle</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b">
            <td class="px-4 py-2">Jean Dupont</td>
            <td class="px-4 py-2">jean@example.com</td>
            <td class="px-4 py-2">Étudiant</td>
            <td class="px-4 py-2">
              <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Suspendre</button>
              <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Supprimer</button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Gestion des cours -->
    <section id="courses-management" class="mb-16">
      <h2 class="text-2xl font-bold mb-4">Gestion des cours</h2>
      <table class="w-full bg-white shadow rounded-lg">
        <thead class="bg-indigo-600 text-white">
          <tr>
            <th class="px-4 py-2">Titre</th>
            <th class="px-4 py-2">Catégorie</th>
            <th class="px-4 py-2">Enseignant</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b">
            <td class="px-4 py-2">Développement Web</td>
            <td class="px-4 py-2">Programmation</td>
            <td class="px-4 py-2">Mme Dupont</td>
            <td class="px-4 py-2">
              <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Modifier</button>
              <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Supprimer</button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

<!-- Gestion des catégories -->
<section id="categories-tags" class="mb-16">
    <h2 class="text-2xl font-bold mb-4">Gestion des catégories</h2>

    <!-- Bouton Ajouter une catégorie -->
    <a href="../Categories/AjouterCategorie.php" class="mb-4 inline-block py-2 px-4 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700">
        Ajouter une catégorie
    </a>

    <!-- Tableau des catégories -->
    <table class="w-full bg-white shadow rounded-lg">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $categorie): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= htmlspecialchars($categorie['nom']) ?></td>
                            <td class="px-4 py-2">
                                <a href="../Categories/ModifierCategorie.php?id=<?= htmlspecialchars($categorie['id_categorie']) ?>" 
                                   class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Modifier</a>
                                <a href="../Categories/SupprimerCategorie.php?id=<?= htmlspecialchars($categorie['id_categorie']) ?>" 
                                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="px-4 py-2 text-center">Aucune catégorie disponible.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
</section>


    

    <!-- Statistiques -->
    <section id="stats">
      <h2 class="text-2xl font-bold mb-4">Statistiques globales</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-bold text-gray-700">Nombre total d'utilisateurs</h3>
          <p class="text-4xl font-bold text-indigo-600 mt-4">1,200</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-bold text-gray-700">Nombre total de cours</h3>
          <p class="text-4xl font-bold text-indigo-600 mt-4">350</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-bold text-gray-700">Top enseignant</h3>
          <p class="text-4xl font-bold text-indigo-600 mt-4">Mme Durand</p>
        </div>
      </div>
    </section>
  </main>

</body>
</html>
