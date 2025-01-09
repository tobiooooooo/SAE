<?php
session_start();

function estConnecte() {
    return isset($_SESSION['user_id']);
}

header('Content-Type: application/json');
echo json_encode(["isLoggedIn" => estConnecte()]);
?>
