<?php
require_once '../classe_utilisateur.php';
session_start();

 Utilisateur ::logout();

header("Location: /index.php"); 
exit();
?>
