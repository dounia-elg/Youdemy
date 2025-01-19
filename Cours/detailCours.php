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

                <!-- Exemple de vidéo ou texte -->
                <div class="aspect-video mb-4">
                    <iframe 
                        class="w-full h-full rounded-lg" 
                        src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                        title="Vidéo du cours" 
                        frameborder="0" 
                        allowfullscreen>
                    </iframe>
                </div>

                <p class="text-gray-600">
                    Ce cours explore les bases de la programmation. Vous apprendrez les variables, les boucles, les fonctions, et bien plus encore grâce à des exemples pratiques.
                </p>
            </div>

            <!-- Détails supplémentaires -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Détails du cours</h2>

                <?php
                // Exemple de données dynamiques récupérées via PHP
                $course = [
                    'titre' => 'Introduction à la programmation',
                    'description' => 'Ce cours couvre les bases de la programmation.',
                    'categorie' => 'Programmation',
                    'tag' => 'Débutant',
                    'enseignant' => 'John Doe',
                    'date_creation' => '2025-01-10',
                ];
                ?>

                <ul class="space-y-3">
                    <li><strong>Titre : </strong><?= htmlspecialchars($course['titre']); ?></li>
                    <li><strong>Description : </strong><?= htmlspecialchars($course['description']); ?></li>
                    <li><strong>Catégorie : </strong><?= htmlspecialchars($course['categorie']); ?></li>
                    <li><strong>Niveau : </strong><?= htmlspecialchars($course['tag']); ?></li>
                    <li><strong>Enseignant : </strong><?= htmlspecialchars($course['enseignant']); ?></li>
                    <li><strong>Date de création : </strong><?= htmlspecialchars($course['date_creation']); ?></li>
                </ul>

                <!-- Bouton d'action -->
                <div class="mt-6 text-center">
                    <a href="cours.php" 
                       class="py-2 px-4 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">
                        Retour à la liste des cours
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
