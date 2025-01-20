<?php

require_once '../classe_utilisateur.php';  
require_once '../Admin/classe_admin.php'; 
require_once '../Enseignant/classe_enseignant.php'; 
require_once '../Etudiant/classe_etudiant.php'; 


session_start();


if (isset($_SESSION['role']) && isset($_SESSION['email']) && isset($_SESSION['password'])) {
    
    if ($_SESSION['role'] == 'admin') {
        $user = new Admin($_SESSION['nom'], $_SESSION['email'], $_SESSION['password'], $_SESSION['role']);
    } elseif ($_SESSION['role'] == 'enseignant') {
        $user = new Enseignant($_SESSION['nom'], $_SESSION['email'], $_SESSION['password'], $_SESSION['role']);
    } elseif ($_SESSION['role'] == 'etudiant') {
        $user = new Etudiant($_SESSION['nom'], $_SESSION['email'], $_SESSION['password'], $_SESSION['role']);
    }

    
    $user->logout();
} else {
    
    header('Location: login.php');
    exit();
}
?>
