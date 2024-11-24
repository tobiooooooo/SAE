<?php
// Ce fichier traite les données soumises par le
// formulaire utilisateur et les insère dans la base de données.
/*session_start();
header("Content-Type: application/json");


    // Connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=nom_de_votre_bd;charset=utf8mb4';
    $username = 'root';
    $password = 'admin123';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérification que l'utilisateur n'a pas déjà répondu
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM responses WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(["success" => false, "message" => "Vous avez déjà répondu à cette enquête."]);
            exit;
        }

        // Insertion des données dans la table responses
        $sql = "INSERT INTO responses (name, age, region, satisfaction, comments, user_id) 
                VALUES (:name, :age, :region, :satisfaction, :comments, :user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $_POST['name'],
            ':age' => $_POST['age'],
            ':region' => $_POST['region'],
            ':satisfaction' => $_POST['satisfaction'],
            ':comments' => $_POST['comments'] ?? '',
            ':user_id' => $_SESSION['user_id']
        ]);

        echo json_encode(["success" => true, "message" => "Merci pour votre participation !"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur : " . $e->getMessage()]);
    }
*/




session_start();
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




