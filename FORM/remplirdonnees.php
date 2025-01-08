<?php
session_start();

$host = '172.16.8.65'; // Adresse du serveur
$dbname = 'grp204_1'; // Nom de la base de données
$username = 'lucas.revault'; // Nom d'utilisateur MySQL
$password = 'de408f2a'; // Mot de passe

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les adhérents qui n'ont pas rempli le formulaire
try {
    $query = "SELECT prenom, nom, email FROM Adherent WHERE formulaire_rempli = 0";
    $stmt = $pdo->query($query);
    $adherents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparer la requête d'insertion dans la table Utilisateur
    $insertStmt = $pdo->prepare("
        INSERT INTO Utilisateur (name, age, region, environment, employment, socialActivities, lifeQuality, healthIssues, supportType, dailyIssues, role, updated_at)
        VALUES (:name, :age, :region, :environment, :employment, :socialActivities, :lifeQuality, :healthIssues, :supportType, :dailyIssues, :role, :updated_at)
    ");

    foreach ($adherents as $adherent) {
        // Données fictives pour remplir les champs requis
        $name = $adherent['prenom'] . ' ' . $adherent['nom']; // Nom complet
        $age = rand(18, 60); // Âge aléatoire
        $region = ['Île-de-France', 'Auvergne-Rhône-Alpes', 'Occitanie'][array_rand([0, 1, 2])]; // Région aléatoire
        $environment = ['Urbain', 'Suburbain', 'Rural'][array_rand([0, 1, 2])]; // Environnement aléatoire
        $employment = ['En emploi', 'En formation', 'Sans emploi'][array_rand([0, 1, 2])]; // Situation professionnelle aléatoire
        $socialActivities = ['Régulière', 'Occasionnelle', 'Rare'][array_rand([0, 1, 2])]; // Activités sociales aléatoires
        $lifeQuality = rand(1, 10); // Qualité de vie entre 1 et 10
        $healthIssues = ['Oui', 'Non'][array_rand([0, 1])]; // Problèmes de santé
        $supportType = ['Soutien moral', 'Soutien matériel', 'Soutien professionnel', 'Autre'][array_rand([0, 1, 2, 3])]; // Type de soutien
        $dailyIssues = ['Stress au travail', 'Gestion du temps', 'Recherche d’emploi', 'Pression des études', 'Gestion de la santé'][array_rand([0, 1, 2, 3, 4])]; // Difficultés majeures
        $role = 'utilisateur'; // Rôle utilisateur
        $updated_at = date('Y-m-d H:i:s'); // Date actuelle

        // Exécution de la requête d'insertion
        $insertStmt->execute([
            ':name' => $name,
            ':age' => $age,
            ':region' => $region,
            ':environment' => $environment,
            ':employment' => $employment,
            ':socialActivities' => $socialActivities,
            ':lifeQuality' => $lifeQuality,
            ':healthIssues' => $healthIssues,
            ':supportType' => $supportType,
            ':dailyIssues' => $dailyIssues,
            ':role' => $role,
            ':updated_at' => $updated_at,
        ]);
    }

    echo "Les utilisateurs ont été insérés avec succès dans la table Utilisateur.";
} catch (PDOException $e) {
    die("Erreur lors de l'insertion des utilisateurs : " . $e->getMessage());
}
?>