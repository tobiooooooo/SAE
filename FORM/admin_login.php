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
        echo "<script> window.location.href='admin_dashboard.html';</script>";
        exit;
    } else {
        $_SESSION['admin'] = false;
        echo "<script>alert('Identifiants invalides.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Requête invalide.'); window.history.back();</script>";
}
?>
