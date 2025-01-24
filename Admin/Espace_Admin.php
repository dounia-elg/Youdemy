<?php
require_once '../connect.php';
require_once '../Enseignant/classe_enseignant.php';
require_once '../Admin/classe_admin.php';
require_once '../Categories/ClasseCategories.php';


$admin = new Admin('Admin', 'admin@gmail.com', 'password');


try {
    $stmt = $conn->prepare("SELECT id, nom, email FROM utilisateur WHERE role = 'enseignant' AND status = 'suspended'");
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
        header("Location: ../Admin/Espace_Admin.php?success=1");
        exit;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['valider'], $_POST['enseignant_id'])) {
      $enseignantId = (int) $_POST['enseignant_id'];

      try {
          $admin->ValiderComptesEnseignants($conn, $enseignantId);
          header("Location: ../Admin/Espace_Admin.php?success=1");
          exit;
      } catch (Exception $e) {
          echo "Erreur : " . $e->getMessage();
      }
  } elseif (isset($_POST['delete'], $_POST['user_id'])) {
      $userId = (int) $_POST['user_id'];

      try {
        $admin->SupprimerUtilisateurs($conn, $userId);
        header("Location: ../Admin/Espace_Admin.php?deleted=1");
        exit;
    } catch (Exception $e) {
        echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }
  } elseif (isset($_POST['change_status'], $_POST['user_id'], $_POST['new_status'])) {
    $userId = (int) $_POST['user_id'];
    $newStatus = $_POST['new_status'];

    try {
        $admin->ChangerStatutUtilisateur($conn, $userId, $newStatus);
        header("Location: ../Admin/Espace_Admin.php?status_changed=1");
        exit;
    } catch (Exception $e) {
        echo "Erreur lors du changement de statut de l'utilisateur : " . $e->getMessage();
    }
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
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800">Youdemy Admin</h1>
            </div>
            <nav class="mt-4">
                <a href="#validate-teachers" class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Validation des enseignants
                </a>
                <a href="#users-management" class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Gestion des utilisateurs
                </a>
                <a href="#categories-tags" class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Catégories & Tags
                </a>
                <a href="#stats" class="flex items-center px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistiques
                </a>
                <a href="../Authentification/logout.php" class="flex items-center px-6 py-3 text-red-600 hover:bg-red-50 transition-colors mt-4">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Se déconnecter
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">1,200</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Cours</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">350</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <!-- Teachers Validation Section -->
                <section id="validate-teachers" class="bg-white rounded-xl shadow-sm mb-8">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900">Validation des enseignants</h2>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php if (!empty($pendingTeachers)): ?>
                                        <?php foreach ($pendingTeachers as $teacher): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($teacher['nom']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($teacher['email']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <form method="POST" action="">
                                                        <input type="hidden" name="enseignant_id" value="<?= $teacher['id'] ?>">
                                                        <button type="submit" name="valider" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            Valider
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Aucun enseignant en attente de validation.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>


    <!-- Gestion des utilisateurs -->


    <h1 class="text-2xl font-bold mt-8 mb-4">Liste des utilisateurs</h1>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="py-2 px-4">ID</th>
                <th class="py-2 px-4">Nom</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $stmt = $conn->prepare("SELECT id, nom, email, status FROM utilisateur");
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
                $users = [];
            }

            foreach ($users as $user): ?>
            <tr class="border-b">
                <td class="py-2 px-4"><?php echo htmlspecialchars($user['id']); ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($user['nom']); ?></td>
                <td class="py-2 px-4"><?php echo htmlspecialchars($user['email']); ?></td>
                <td class="py-2 px-4">
                    <form method="post">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="new_status" class="bg-gray-200 border border-gray-300 rounded py-1 px-2">
                            <option value="active" <?php echo $user['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="suspended" <?php echo $user['status'] == 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                        </select>
                        <button type="submit" name="change_status" class="bg-blue-500 text-white py-1 px-3 rounded">Changer</button>
                        <button type="submit" name="delete" class="bg-red-500 text-white py-1 px-3 rounded">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    

<!-- Gestion des catégories -->
<section id="categories-tags" class="mb-16">
    <h2 class="text-2xl font-bold mb-4">Gestion des catégories</h2>

    <!-- Bouton Ajouter une catégorie -->
    <a href="../Categories/AjouterCategorie.php" class="mb-4 inline-block py-2 px-4 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700">
        Ajouter une catégorie
    </a>

    <!-- Tableau des catégories -->
<table class="w-full bg-white shadow rounded-lg">
    <thead class="bg-black text-white">
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
                           class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</a>
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


  </main>

</body>
</html>
