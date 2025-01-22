<?php
session_start();
require_once '../connect.php';  
require_once '../Cours/ClasseCours.php';  

if (!isset($_SESSION['id_enseignant'])) {
    header("Location: /Authentification/login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idCours = $_GET['id'];

    $cours = Cours::getCoursById($conn, $idCours);

    if ($cours) {
        
        if ($cours->supprimerCours($conn)) {
            header("Location: /Enseignant/Espace_Enseignant.php?message=Cours supprimé avec succès.");
            exit();
        } else {
            echo "Erreur lors de la suppression du cours.";
        }
    } else {
        echo "Le cours spécifié n'existe pas.";
    }
} else {
    echo "ID du cours invalide.";
}
?>
