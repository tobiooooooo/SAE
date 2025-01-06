<?php
//// Configuration de la base de données
//$host = '172.16.8.65'; // Remplace par l'adresse de ton serveur
//$dbname = 'grp204_1'; // Nom de la base de données
//$username = 'lucas.revault'; // Nom d'utilisateur
//$password = 'de408f2a'; // Mot de passe

session_start();

$host = '172.16.8.65'; // Adresse locale (localhost)
$dbname = 'grp204_1'; // Nom de la base de données locale
$username = 'lucas.revault'; // Nom d'utilisateur MySQL par défaut sur XAMPP
$password = 'de408f2a'; // Le mot de passe par défaut pour root est vide sur XAMPP

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

    // Vérification si l'email existe déjà
    $stmt = $pdo->prepare("SELECT * FROM Adherent WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "Cette adresse e-mail est déjà utilisée. Veuillez utiliser une autre adresse.";
        exit;
    }

    // Hachage du mot de passe
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

        // Stocker l'ID et le nom complet dans la session
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $prenom . ' ' . $nom;

        header("Location: ../FORM/formulaire.html");
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'adhérent : " . $e->getMessage();
    }
}
?>
