<?php
session_start(); // Démarre la session

// Supprime toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige vers la page d'accueil
header("Location: ../accueil/Accueil.html");
exit;
?>
