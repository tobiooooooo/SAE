<?php
session_start();
header("Content-Type: application/json");

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
    exit;
}

// Configuration de la base de données
$host = '172.16.8.65';
$dbname = 'grp204_1';
$username = 'lucas.revault';  // Remplacez par vos identifiants
$password = 'de408f2a';       // Remplacez par votre mot de passe

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Calcul des indicateurs à partir des données de la table `users3`
    $stmt = $pdo->query("SELECT COUNT(*) AS total_users, AVG(age) AS average_age FROM users3");
    $generalStats = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalUsers = $generalStats['total_users'] ?? 0;
    $averageAge = round($generalStats['average_age'] ?? 0, 2);

    // Répartition des données
    $regions = $pdo->query("SELECT region, COUNT(*) AS count FROM users3 GROUP BY region")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $satisfaction = $pdo->query("SELECT lifeQuality, COUNT(*) AS count FROM users3 GROUP BY lifeQuality")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $environments = $pdo->query("SELECT environnement, COUNT(*) AS count FROM users3 GROUP BY environnement")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $socialActivities = $pdo->query("SELECT socialActivities, COUNT(*) AS count FROM users3 GROUP BY socialActivities")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $healthIssues = $pdo->query("SELECT healthIssues, COUNT(*) AS count FROM users3 GROUP BY healthIssues")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $supportTypes = $pdo->query("SELECT supportType, COUNT(*) AS count FROM users3 GROUP BY supportType")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    // Retourner les indicateurs en JSON
    echo json_encode([
        'success' => true,
        'data' => [
            'total_users' => $totalUsers,
            'average_age' => $averageAge,
            'regions' => $regions,
            'satisfaction' => $satisfaction,
            'environments' => $environments,
            'social_activities' => $socialActivities,
            'health_issues' => $healthIssues,
            'support_types' => $supportTypes,
        ]
    ]);

} catch (PDOException $e) {
    // Gérer les erreurs de base de données
    error_log("Erreur PDO : " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données.']);
}
