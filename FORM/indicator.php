<?php
session_start();
header("Content-Type: application/json");

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
    exit;
}

// Chemin vers le fichier JSON contenant les utilisateurs
$dataFile = __DIR__ . '/data/users.json';

// Charger les données
if (file_exists($dataFile)) {
    $users = json_decode(file_get_contents($dataFile), true) ?? [];

    // Calculer les indicateurs
    $totalUsers = count($users);
    $averageAge = array_sum(array_column($users, 'age')) / $totalUsers;

    // Répartition par région
    $regions = array_count_values(array_column($users, 'region'));

    // Satisfaction globale
    $satisfactionCounts = array_count_values(array_column($users, 'satisfaction'));

    // Retourner les indicateurs
    echo json_encode([
        'success' => true,
        'data' => [
            'total_users' => $totalUsers,
            'average_age' => round($averageAge, 2),
            'regions' => $regions,
            'satisfaction' => $satisfactionCounts,
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée disponible.']);
}

