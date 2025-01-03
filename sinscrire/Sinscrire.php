<?php
//// Configuration de la base de données
//$host = '172.16.8.65'; // Remplace par l'adresse de ton serveur
//$dbname = 'grp204_1'; // Nom de la base de données
//$username = 'lucas.revault'; // Nom d'utilisateur
//$password = 'de408f2a'; // Mot de passe

session_start();


$host = '127.0.0.1'; // Adresse locale (localhost)
$dbname = 'grp204_1'; // Nom de la base de données locale
$username = 'root'; // Nom d'utilisateur MySQL par défaut sur XAMPP
$password = ''; // Le mot de passe par défaut pour root est vide sur XAMPP


try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


// Vérification des données envoyées par le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    // Validation des champs
    if (empty($prenom) || empty($nom) || empty($email) || empty($mot_de_passe)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse e-mail n'est pas valide.";
        exit;
    }

    if (strlen($mot_de_passe) < 8) {
        echo "Le mot de passe doit contenir au moins 8 caractères.";
        exit;
    }

    // Hachage du mot de passe pour la sécurité
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    try {
        // Insertion dans la base de données
        $stmt = $pdo->prepare("INSERT INTO Adherent (prenom, nom, email, mot_de_passe) VALUES (:prenom, :nom, :email, :mot_de_passe)");
        $stmt->execute([
            ':prenom' => $prenom,
            ':nom' => $nom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe_hash
        ]);
        echo "Adhérent ajouté avec succès !";
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') { // Violation de contrainte UNIQUE (e-mail déjà existant)
            echo "L'adresse e-mail est déjà utilisée.";
        } else {
            echo "Erreur lors de l'ajout de l'adhérent : " . $e->getMessage();
        }
    }

    $_SESSION['user_id'] = $pdo->lastInsertId(); // ID de l'utilisateur ajouté
    $_SESSION['user_name'] = $prenom . ' ' . $nom; // Nom complet


        header("Location: ../FORM/formulaire.html"); // Rediriger vers le formulaire si non rempli

}
?>