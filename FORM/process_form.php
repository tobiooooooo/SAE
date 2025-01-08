<?php
// Configuration de la base de données
session_start();
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
        'support_type', 'daily_issues'
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
    $sql = "INSERT INTO Utilisateur (name, age, region, environment, employment,
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


    if (!isset($_SESSION['user_i    d'])) {
        echo "Erreur : utilisateur non identifié. Veuillez vous reconnecter.";
        header("Location: ../SeConnecter.html");
        exit;
    }

    // Mettre à jour la colonne formulaire_rempli
    $stmt = $pdo->prepare("UPDATE Adherent SET formulaire_rempli = TRUE WHERE id_adherent = :id_adherent");
    $stmt->execute([':id_adherent' => $_SESSION['user_id']]);
    echo "Données insérées avec succès !";
    header("Location: ../accueil/Accueil.html");


} catch (PDOException $e) {
    // Gérer les erreurs liées à la base de données
    error_log("Erreur PDO : " . $e->getMessage());
    echo "Une erreur s'est produite. Veuillez réessayer plus tard.";
}



