<?php
session_start();

// Identifiants admin (à personnaliser)
$adminCredentials = [
    'username' => 'admin',
    'password' => 'oui',
];

// Vérifier si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier les identifiants
    if ($username === $adminCredentials['username'] && $password === $adminCredentials['password']) {
        $_SESSION['admin'] = true;
        header('Location: admin_dashboard.html'); // Redirige vers le tableau de bord
        exit;
    } else {
        $_SESSION['admin'] = false;
        echo "<p style='color: red;'>Identifiants invalides.</p>";
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}

