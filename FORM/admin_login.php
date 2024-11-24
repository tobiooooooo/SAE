<?php
session_start();

// Identifiants admin (à personnaliser)
$adminCredentials = [
    'username' => 'admin',
    'password' => 'password123',
];

// Vérifier si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier les identifiants
    if ($username === $adminCredentials['username'] && $password === $adminCredentials['password']) {
        $_SESSION['admin'] = true; // Activer la session admin

        // Redirection vers le tableau de bord
        header('Location: admin_dashboard.html');
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Identifiants invalides.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}

