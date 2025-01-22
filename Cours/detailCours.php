<?php
require_once '../connect.php'; // Connexion à la base de données
require_once '../Cours/ClasseCours.php'; // Inclure la classe Cours

// Vérifier si un identifiant de cours est passé dans l'URL
if (isset($_GET['id_cours'])) {
    $idCours = intval($_GET['id_cours']);
    $cours = Cours::getCoursById($conn, $idCours);

    if (!$cours) {
        // Si aucun cours n'est trouvé, afficher un message d'erreur
        $messageErreur = "Cours introuvable.";
    }
} else {
    // Rediriger ou afficher une erreur si aucun ID n'est passé
    header("Location: ");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto py-10 px-6">
        <!-- En-tête de la page -->
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">Détails du cours</h1>

        <!-- Conteneur principal avec disposition en deux colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Contenu principal (vidéo ou texte) -->
            <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contenu du cours</h2>

                <?php if (isset($cours)): ?>
                    <div class="aspect-video mb-4">
                        <!-- Remplacez l'exemple de vidéo par le contenu dynamique si nécessaire -->
                        <iframe 
                                        width="100%" 
                                        height="400" 
                                        src="<?= htmlspecialchars(str_replace('watch?v=', 'embed/', $cours->getContenu())) ?>" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                    </div>

                <?php else: ?>
                    <p class="text-red-500">Le contenu du cours n'est pas disponible.</p>
                <?php endif; ?>
            </div>

            <!-- Détails supplémentaires -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Détails du cours</h2>

                <?php if (isset($cours)): ?>
                    <ul class="space-y-3">
                        <li><strong>Titre : </strong><?= htmlspecialchars($cours->getTitre()); ?></li>
                        <li><strong>Description : </strong><?= htmlspecialchars($cours->getDescription()); ?></li>
                        <li><strong>Catégorie : </strong><?= htmlspecialchars($cours->getCategorie()); ?></li>
                        <li><strong>Enseignant : </strong><?= htmlspecialchars($cours->getuser()); ?></li>
                    </ul>
                <?php else: ?>
                    <p class="text-red-500"><?= htmlspecialchars($messageErreur); ?></p>
                <?php endif; ?>

                <!-- Bouton d'action -->
                <div class="mt-6 text-center">
                    <a href="../Etudiant/myCourses.php" 
                       class="py-2 px-4 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">
                        Retour à la liste des cours
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
