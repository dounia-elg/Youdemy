<?php
require_once '../connect.php';
require_once '../Cours/ClasseCours.php';
session_start();  

$idEtudiant = isset( $_SESSION['id_user']) ?  $_SESSION['id_user'] : null;
if (isset($_POST['id_cours'])) {
    $idCours = $_POST['id_cours'];
    
} else {
    echo "Erreur : ID du cours manquant.";
}

if (!$idEtudiant) {
    $message = "Vous devez être connecté pour vous inscrire.";
} else {
$stmt = $conn->prepare("SELECT COUNT(*) FROM utilisateur WHERE id = :idEtudiant");
$stmt->execute(['idEtudiant' => $idEtudiant]);
$etudiantExists = $stmt->fetchColumn() > 0;

if (!$etudiantExists) {
    $message = "L'étudiant avec cet ID n'existe pas dans la base de données.";
} else {
    $cours = new Cours($conn, null, null, null, null, null);  
    if ($cours->inscrireCours($idEtudiant, $idCours)) {
        $message = "Inscription réussie !";
    } else {
        $message = "Erreur lors de l'inscription.";
    }
}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($etudiantExists && isset($_POST['id_etudiant']) && isset($_POST['id_cours'])) {
        $idEtudiant = (int) $_POST['id_etudiant']; 
        $idCours = (int) $_POST['id_cours']; 

        if ($cours->inscrireCours($idEtudiant, $idCours)) {
            $message = "Inscription réussie !";
            
        } else {
            $message = "L'étudiant est déjà inscrit à ce cours.";
        }
    } else {
        $message = "Veuillez remplir tous les champs ou l'étudiant n'existe pas.";
    }

}

$stmt = $conn->query("SELECT * FROM cours");
$coursList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription aux Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Inscription à un Cours</h1>

        <!-- Afficher le message -->
        <?php if ($message): ?>
            <div class="mb-4 text-center text-sm <?= $message === 'Inscription réussie !' ? 'text-green-600' : 'text-red-600' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="id_etudiant" value="<?= htmlspecialchars($idEtudiant) ?>">

            <div>
                <label for="id_cours" class="block text-sm font-medium text-gray-700">Choisir un Cours:</label>
                <select name="id_cours" required class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Sélectionner un cours --</option>
                    <?php foreach ($coursList as $cours): ?>
                        <option value="<?= htmlspecialchars($cours['id_cour']) ?>">
                            <?= htmlspecialchars($cours['titre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    S'inscrire
                </button>
            </div>
        </form>
    </div>

</body>
</html>
