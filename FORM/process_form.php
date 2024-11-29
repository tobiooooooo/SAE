<?php
// Ce fichier traite les données soumises par le
// formulaire utilisateur et les insère dans la base de données.

// Connexion à la base de données MariaDB
$host = '172.16.8.65';
$dbname = 'grp_204';
$username = 'lucas.revault';  // Remplace par ton utilisateur MariaDB
$password = 'de408f2a';      // Remplace par ton mot de passe MariaDB

try {
    // Connexion avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données envoyées depuis le formulaire
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $region = $_POST['region'] ?? '';
    $satisfaction = $_POST['satisfaction'] ?? '';
    $comments = $_POST['comments'] ?? '';

    // Insérer les données dans la table `users`
    $sql = "INSERT INTO users (name, age, region, satisfaction, comments) 
            VALUES (:name, :age, :region, :satisfaction, :comments)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':age' => $age,
        ':region' => $region,
        ':satisfaction' => $satisfaction,
        ':comments' => $comments
    ]);

    echo "Données insérées avec succès !";

} catch (PDOException $e) {
    die("Erreur de connexion ou d'insertion : " . $e->getMessage());
}







/*session_start();
header("Content-Type: application/json");

// Chemin vers le fichier JSON pour stocker les données des utilisateurs
$dataFile = __DIR__ . '/data/users.json';

    // Récupérer les données du formulaire
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $region = $_POST['region'] ?? '';
    $satisfaction = $_POST['satisfaction'] ?? '';

    // Valider les champs obligatoires
    if (empty($name) || empty($age) || empty($region) || empty($satisfaction)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis.']);
        exit;
    }

    // Charger les données existantes
    $users = [];
    if (file_exists($dataFile)) {
        $users = json_decode(file_get_contents($dataFile), true) ?? [];
    }

    // Ajouter les nouvelles données
    $newUser = [
        'name' => htmlspecialchars($name),
        'age' => (int)$age,
        'region' => htmlspecialchars($region),
        'satisfaction' => htmlspecialchars($satisfaction),
        'timestamp' => date('Y-m-d H:i:s'),
    ];
    $users[] = $newUser;

    // Enregistrer les données mises à jour
    if (file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur enregistré avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement des données.']);
    }

*/


