<?php
// Configuration de la base de données
$host = '172.16.8.65';
$dbname = 'grp204_1';
$username = 'lucas.revault';
$password = 'de408f2a';

try {
    // Connexion avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données envoyées depuis le formulaire
    $fields = [
        'name', 'age', 'region', 'environment', 'employment',
        'social_activities', 'life_quality', 'health_issues',
        'support_type', 'daily_issues', 'role'
    ];

    $data = [];
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Le champ '$field' est obligatoire.");
        }
        $data[$field] = htmlspecialchars($_POST[$field]);
    }

    // Débogage des données POST (à commenter après débogage)
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    // Insérer les données dans la table `users3`
    $sql = "INSERT INTO users3 (name, age, region, environnement, employment,
                                socialActivities, lifeQuality, healthIssues, 
                                supportType, dailyIssues, role) 
            VALUES (:name, :age, :region, :environment, :employment, :social_activities,
                    :life_quality, :health_issues, :support_type, :daily_issues, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $data['name'],
        ':age' => (int)$data['age'],
        ':region' => $data['region'],
        ':environment' => $data['environment'],
        ':employment' => $data['employment'],
        ':social_activities' => $data['social_activities'],
        ':life_quality' => (int)$data['life_quality'],
        ':health_issues' => $data['health_issues'],
        ':support_type' => $data['support_type'],
        ':daily_issues' => $data['daily_issues'],
        ':role' => $data['role'] ?? 'user',
    ]);

    echo "Données insérées avec succès !";

} catch (PDOException $e) {
    // Gérer les erreurs liées à la base de données
    error_log("Erreur PDO : " . $e->getMessage());
    echo "Une erreur s'est produite. Veuillez réessayer plus tard.";
} catch (Exception $e) {
    // Gérer les erreurs générales
    echo "Erreur : " . $e->getMessage();
}




/*

session_start();
header("Content-Type: application/json");

// Chemin vers le fichier JSON pour stocker les données des utilisateurs
$dataFile = __DIR__ . '/data/users.json';

// Récupérer les données du formulaire
$name = $_POST['name'] ?? '';
$age = $_POST['age'] ?? '';
$region = $_POST['region'] ?? '';
$environment = $_POST['environment'] ?? '';
$employment = $_POST['employment'] ?? '';
$socialActivities = $_POST['social_activities'] ?? '';
$lifeQuality = $_POST['life_quality'] ?? '';
$healthIssues = $_POST['health_issues'] ?? '';
$supportType = $_POST['support_type'] ?? '';
$dailyIssues = $_POST['daily_issues'] ?? '';
$role = $_POST['role'] ?? 'user'; // Par défaut, le rôle est "user"

// Validation des champs obligatoires
if (
    empty($name) || empty($age) || empty($region) || empty($environment) ||
    empty($employment) || empty($socialActivities) || empty($lifeQuality) ||
    empty($healthIssues) || empty($supportType) || empty($dailyIssues)
) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis.']);
    exit;
}

// Gestion du rôle administrateur
if ($role === 'admin') {
    // Rediriger les administrateurs vers la page de connexion admin
    header('Location: admin_login.php');
    exit;
}

// Charger les données existantes
$users = [];
if (file_exists($dataFile)) {
    $users = json_decode(file_get_contents($dataFile), true) ?? [];
}

// Ajouter les nouvelles données utilisateur
$newUser = [
    'name' => htmlspecialchars($name),
    'age' => (int)$age,
    'region' => htmlspecialchars($region),
    'environment' => htmlspecialchars($environment),
    'employment' => htmlspecialchars($employment),
    'social_activities' => htmlspecialchars($socialActivities),
    'life_quality' => (int)$lifeQuality,
    'health_issues' => htmlspecialchars($healthIssues),
    'support_type' => htmlspecialchars($supportType),
    'daily_issues' => htmlspecialchars($dailyIssues),
    'timestamp' => date('Y-m-d H:i:s'),
];
$users[] = $newUser;

// Enregistrer les données mises à jour
if (file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    // Réponse HTML pour confirmer l'enregistrement
    echo json_encode(['success' => true, 'message' => 'Données enregistrées avec succès.']);
} else {
    // Réponse HTML en cas d'erreur d'enregistrement
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement des données.']);
}




*/