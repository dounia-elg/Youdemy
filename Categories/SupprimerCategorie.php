<?php
require_once '../connect.php'; 
require_once '../Categories/ClasseCategories.php'; 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idCategorie = (int) $_GET['id']; 
    echo "ID Categorie: " . $idCategorie;  

    $categorie = new Categories($conn, '', $idCategorie); 

    if ($categorie->supprimerCategorie()) {
        header("Location: ../Admin/Espace_Admin.php?success=2");
        exit;
    } else {
        echo "Erreur lors de la suppression de la catégorie.";
    }
} else {
    echo "ID de catégorie invalide.";
}
?>
