<?php
session_start();

$host = '172.16.8.65';
$dbname = 'grp204_1';
$username = 'lucas.revault';
$password = 'de408f2a';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<script>alert('Erreur de connexion à la base de données : " . $e->getMessage() . "'); window.history.back();</script>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    if (empty($prenom) || empty($nom) || empty($email) || empty($mot_de_passe)) {
        echo "<script>alert('Tous les champs sont obligatoires.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Adresse e-mail non valide.'); window.history.back();</script>";
        exit;
    }

    if (strlen($mot_de_passe) < 8) {
        echo "<script>alert('Le mot de passe doit contenir au moins 8 caractères.'); window.history.back();</script>";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM Adherent WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "<script>alert('Cette adresse e-mail est déjà utilisée.'); window.history.back();</script>";
        exit;
    }

    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO Adherent (prenom, nom, email, mot_de_passe) VALUES (:prenom, :nom, :email, :mot_de_passe)");
        $stmt->execute([
            ':prenom' => $prenom,
            ':nom' => $nom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe_hash,
        ]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $prenom . ' ' . $nom;

        echo "<script>alert('Inscription réussie !'); window.location.href='../FORM/formulaire.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erreur lors de l\'inscription : " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
