<?php
//// Configuration de la base de données
//$host = '172.16.8.65';
//$dbname = 'grp204_1';
//$username = 'lucas.revault';
//$password = 'de408f2a';


$host = '127.0.0.1'; // Adresse locale (localhost)
$dbname = 'grp204_1'; // Nom de la base de données locale
$username = 'root'; // Nom d'utilisateur MySQL par défaut sur XAMPP
$password = ''; // Le mot de passe par défaut pour root est vide sur XAMPP



session_start();

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
            // Stocker les données utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
            $_SESSION['formulaire_rempli'] = $user['formulaire_rempli'];


            if ($user['formulaire_rempli']) {
                header("Location: ../accueil/Accueil.html"); // Rediriger vers l'accueil si le formulaire est déjà rempli
            } else {
                header("Location: ../FORM/formulaire.html");// Rediriger vers le formulaire si non rempli
            }
            exit();
        }

    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
    }
}
?>