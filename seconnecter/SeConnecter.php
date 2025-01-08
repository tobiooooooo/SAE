<?php
session_start();  // Démarre la session pour suivre l'état de connexion

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

// Traitement du formulaire de connexion
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

        // Vérification du mot de passe
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Enregistrement des infos dans la session
            $_SESSION['user_id'] = $user['id_adherent'];
            $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
            $_SESSION['formulaire_rempli'] = $user['formulaire_rempli'];

            // Redirections selon l'état du formulaire
            if ($user['formulaire_rempli']) {
                header("Location: ../accueil/Accueil.html");
            } else {
                header("Location: ../FORM/formulaire.html");
            }
            exit;
        } else {
            echo "Identifiants incorrects.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
    }
}
?>
