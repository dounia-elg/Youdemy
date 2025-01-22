<?php
require_once '../connect.php'; 
session_start();

$idEtudiant = isset( $_SESSION['id_user']) ?  $_SESSION['id_user'] : null;

if (!$idEtudiant) {
    die("Vous devez être connecté pour vous désinscrire.");
}

if (isset($_GET['id_cours'])) {
    $idCours = (int) $_GET['id_cours'];

    $stmt = $conn->prepare("SELECT * FROM inscription WHERE id_etudiant = :id_etudiant AND id_cours = :id_cours");
    $stmt->bindParam(':id_etudiant', $idEtudiant, PDO::PARAM_INT);
    $stmt->bindParam(':id_cours', $idCours, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $deleteStmt = $conn->prepare("DELETE FROM inscription WHERE id_etudiant = :id_etudiant AND id_cours = :id_cours");
        $deleteStmt->bindParam(':id_etudiant', $idEtudiant, PDO::PARAM_INT);
        $deleteStmt->bindParam(':id_cours', $idCours, PDO::PARAM_INT);
        
        if ($deleteStmt->execute()) {
            $message = "Désinscription réussie !";
        } else {
            $message = "Erreur lors de la désinscription. Veuillez réessayer.";
        }
    } else {
        $message = "Vous n'êtes pas inscrit à ce cours.";
    }
} else {
    $message = "Aucun cours sélectionné.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Désinscription - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Désinscription du Cours</h1>

        <!-- Affichage du message -->
        <?php if (isset($message)): ?>
            <div class="mb-4 text-center text-sm <?= strpos($message, 'réussie') !== false ? 'text-green-600' : 'text-red-600' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Redirection ou retour à la page précédente -->
        <div class="text-center">
            <a href="javascript:history.back()" class="text-indigo-600 hover:underline">Retour aux cours</a>
        </div>
    </div>

</body>
</html>
