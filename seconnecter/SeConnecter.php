<?php
// Configuration de la base de données
$host = '172.16.8.65';
$dbname = 'grp204_1';
$username = 'lucas.revault';
$password = 'de408f2a';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    if (empty($email) || empty($mot_de_passe)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM Adherent WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            echo "Connexion réussie. Bienvenue, " . htmlspecialchars($user['prenom']) . "!";
        } else {
            echo "Adresse e-mail ou mot de passe incorrect.";
        }

    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
    }
    session_start();
    $_SESSION['user_id'] = $pdo->lastInsertId(); // ID de l'utilisateur ajouté
    $_SESSION['user_name'] = $prenom . ' ' . $nom; // Nom complet
    header("Location: ../accueil/Accueil.html");
    exit;
    $etatconnecter = true;
}
?>
