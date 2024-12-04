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
    $averageAge = $totalUsers > 0 ? array_sum(array_column($users, 'age')) / $totalUsers : 0;

    // Répartition des données
    $regions = array_count_values(array_column($users, 'region'));
    $satisfaction = array_count_values(array_column($users, 'life_quality'));
    $environments = array_count_values(array_column($users, 'environment'));
    $socialActivities = array_count_values(array_column($users, 'social_activities'));
    $healthIssues = array_count_values(array_column($users, 'health_issues'));
    $supportTypes = array_count_values(array_column($users, 'support_type'));

    // Retourner les indicateurs
    echo json_encode([
        'success' => true,
        'data' => [
            'total_users' => $totalUsers,
            'average_age' => round($averageAge, 2),
            'regions' => $regions,
            'satisfaction' => $satisfaction,
            'environments' => $environments,
            'social_activities' => $socialActivities,
            'health_issues' => $healthIssues,
            'support_types' => $supportTypes,
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée disponible.']);
}
