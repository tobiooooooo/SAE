<?php
session_start();
header("Content-Type: application/json");

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
    exit;
}

//// Configuration de la base de données
//$host = '172.16.8.65';
//$dbname = 'grp204_1';
//$username = 'lucas.revault';  // Remplacez par vos identifiants
//$password = 'de408f2a';       // Remplacez par votre mot de passe

$host = '172.16.8.65'; // Adresse locale (localhost)
$dbname = 'grp204_1'; // Nom de la base de données locale
$username = 'lucas.revault'; // Nom d'utilisateur MySQL par défaut sur XAMPP
$password = 'de408f2a'; // Le mot de passe par défaut pour root est vide sur XAMPP



try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Calcul des indicateurs à partir des données de la table `users3`
    $stmt = $pdo->query("SELECT COUNT(*) AS total_users, AVG(age) AS average_age FROM Utilisateur");
    $generalStats = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalUsers = $generalStats['total_users'] ?? 0;
    $averageAge = isset($generalStats['average_age']) ? round($generalStats['average_age'], 2) : 0;


    // Répartition des données
    $regions = $pdo->query("SELECT region, COUNT(*) AS count FROM Utilisateur GROUP BY region")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $satisfaction = $pdo->query("SELECT lifeQuality, COUNT(*) AS count FROM Utilisateur GROUP BY lifeQuality")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $environments = $pdo->query("SELECT environment, COUNT(*) AS count FROM Utilisateur GROUP BY environment")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $socialActivities = $pdo->query("SELECT socialActivities, COUNT(*) AS count FROM Utilisateur GROUP BY socialActivities")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $healthIssues = $pdo->query("SELECT healthIssues, COUNT(*) AS count FROM Utilisateur GROUP BY healthIssues")
        ->fetchAll(PDO::FETCH_KEY_PAIR);

    $supportTypes = $pdo->query("SELECT supportType, COUNT(*) AS count FROM Utilisateur GROUP BY supportType")
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
