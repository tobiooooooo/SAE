<?php
session_start();
header("Content-Type: application/json");

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
    exit;
}

// Chemin vers le fichier JSON
$dataFile = __DIR__ . '/data/users.json';

// Charger et afficher les données
if (file_exists($dataFile)) {
    $users = json_decode(file_get_contents($dataFile), true) ?? [];
    echo json_encode(['success' => true, 'data' => $users]);
} else {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée disponible.']);
}

