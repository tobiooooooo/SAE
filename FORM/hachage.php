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

// Tableau de données pour 50 adhérents
$adherents = [
    ['Jean', 'Dupont', 'jean.dupont@example.com', 'password123', '2025-01-01', 1],
    ['Marie', 'Durand', 'marie.durand@example.com', 'securepass', '2025-01-02', 0],
    ['Luc', 'Martin', 'luc.martin@example.com', 'lucpass', '2025-01-03', 1],
    ['Alice', 'Robert', 'alice.robert@example.com', 'mypassword', '2025-01-04', 1],
    ['Paul', 'Bernard', 'paul.bernard@example.com', 'testpass', '2025-01-05', 0],
    ['Emma', 'Petit', 'emma.petit@example.com', 'emma2025', '2025-01-06', 1],
    ['Noah', 'Richard', 'noah.richard@example.com', 'noahpass', '2025-01-07', 0],
    ['Chloe', 'Durand', 'chloe.durand@example.com', 'chloepass', '2025-01-08', 1],
    ['Lucas', 'Moreau', 'lucas.moreau@example.com', 'lucaspass', '2025-01-09', 0],
    ['Mia', 'Simon', 'mia.simon@example.com', 'miapass', '2025-01-10', 1],
    ['Liam', 'Lemoine', 'liam.lemoine@example.com', 'liampass', '2025-01-11', 0],
    ['Sophia', 'Gauthier', 'sophia.gauthier@example.com', 'sophiapass', '2025-01-12', 1],
    ['Nathan', 'Lopez', 'nathan.lopez@example.com', 'nathan2025', '2025-01-13', 0],
    ['Isabella', 'Roche', 'isabella.roche@example.com', 'isapass', '2025-01-14', 1],
    ['Ethan', 'Blanc', 'ethan.blanc@example.com', 'ethanpass', '2025-01-15', 0],
    ['Charlotte', 'Fournier', 'charlotte.fournier@example.com', 'charlotte2025', '2025-01-16', 1],
    ['Benjamin', 'Girard', 'benjamin.girard@example.com', 'benpass', '2025-01-17', 0],
    ['Ella', 'Chevalier', 'ella.chevalier@example.com', 'ellapass', '2025-01-18', 1],
    ['Jack', 'Gonzalez', 'jack.gonzalez@example.com', 'jackpass', '2025-01-19', 0],
    ['Amelia', 'Martinez', 'amelia.martinez@example.com', 'amelia2025', '2025-01-20', 1],
    ['James', 'Perrin', 'james.perrin@example.com', 'jamespass', '2025-01-21', 0],
    ['Harper', 'Roux', 'harper.roux@example.com', 'harper2025', '2025-01-22', 1],
    ['Henry', 'Vincent', 'henry.vincent@example.com', 'henrypass', '2025-01-23', 0],
    ['Victoria', 'Fabre', 'victoria.fabre@example.com', 'victoria2025', '2025-01-24', 1],
    ['Mason', 'Leclerc', 'mason.leclerc@example.com', 'masonpass', '2025-01-25', 0],
    ['Luna', 'Benoit', 'luna.benoit@example.com', 'lunapass', '2025-01-26', 1],
    ['Oliver', 'Lucas', 'oliver.lucas@example.com', 'oliverpass', '2025-01-27', 0],
    ['Emma', 'Dupuis', 'emma.dupuis@example.com', 'emma2025', '2025-01-28', 1],
    ['Sophia', 'Carpentier', 'sophia.carpentier@example.com', 'sophiapass', '2025-01-29', 0],
    ['Jackson', 'Guillot', 'jackson.guillot@example.com', 'jacksonpass', '2025-01-30', 1],
    ['Victoria', 'Adam', 'victoria.adam@example.com', 'victoriapass', '2025-01-31', 0],
    ['Ella', 'Moulin', 'ella.moulin@example.com', 'ellapass', '2025-02-01', 1],
    ['Benjamin', 'Germain', 'benjamin.germain@example.com', 'benpass', '2025-02-02', 0],
    ['Ethan', 'Collet', 'ethan.collet@example.com', 'ethanpass', '2025-02-03', 1],
    ['James', 'Pruvost', 'james.pruvost@example.com', 'jamespass', '2025-02-04', 0],
    ['Mason', 'Chapel', 'mason.chapel@example.com', 'masonpass', '2025-02-05', 1],
    ['Luna', 'Faure', 'luna.faure@example.com', 'lunapass', '2025-02-06', 0],
    ['Charlotte', 'Descartes', 'charlotte.descartes@example.com', 'charlotte2025', '2025-02-07', 1],
    ['Lucas', 'Riviere', 'lucas.riviere@example.com', 'lucaspass', '2025-02-08', 0],
    ['Grace', 'Green', 'grace.green@example.com', 'gracepass', '2025-02-09', 1],
    ['Daniel', 'Lee', 'daniel.lee@example.com', 'danielpass', '2025-02-10', 1],
    ['Emma', 'Brown', 'emma.brown@example.com', 'brownpass', '2025-02-11', 0],
    ['Olivia', 'Wright', 'olivia.wright@example.com', 'oliviapass', '2025-02-12', 1],
    ['Sam', 'Turner', 'sam.turner@example.com', 'sampass', '2025-02-13', 0],
    ['Tina', 'Evans', 'tina.evans@example.com', 'tinapass', '2025-02-14', 1],
    ['Karen', 'Hall', 'karen.hall@example.com', 'karenpass', '2025-02-15', 0],
];

// Insérer les données dans la base
try {
    $stmt = $pdo->prepare("
        INSERT INTO Adherent (prenom, nom, email, mot_de_passe, date_inscription, formulaire_rempli)
        VALUES (:prenom, :nom, :email, :mot_de_passe, :date_inscription, :formulaire_rempli)
    ");

    foreach ($adherents as $adherent) {
        $hashedPassword = password_hash($adherent[3], PASSWORD_BCRYPT);

        $stmt->execute([
            ':prenom' => $adherent[0],
            ':nom' => $adherent[1],
            ':email' => $adherent[2],
            ':mot_de_passe' => $hashedPassword,
            ':date_inscription' => $adherent[4],
            ':formulaire_rempli' => $adherent[5],
        ]);
    }

    echo "Les 50 adhérents ont été insérés avec succès.";
} catch (PDOException $e) {
    die("Erreur lors de l'insertion des adhérents : " . $e->getMessage());
}
?>