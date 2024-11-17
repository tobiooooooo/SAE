
<?php
session_start();
header("Content-Type: application/json");

// Initialisation d'une réponse par défaut
$response = ["success" => false, "message" => "Une erreur est survenue."];

// Vérification de la méthode HTTP
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $action = $_GET["action"] ?? null;

    if ($action === "get_chart_data") {
        // Génération des données dynamiques pour les graphiques
        $chartData = [
            [
                "thematique" => "Lieu de vie",
                "reponses" => [
                    "famille" => 40,
                    "independant" => 30,
                    "autre" => 20,
                ],
            ],
            [
                "thematique" => "Qualité de vie",
                "reponses" => [
                    "positive" => 60,
                    "negative" => 40,
                ],
            ],
        ];

        echo json_encode($chartData);
        exit;
    }

    if ($action === "check_session") {
        // Vérification si l'utilisateur est admin
        $isAdmin = isset($_SESSION["is_admin"]) && $_SESSION["is_admin"];
        echo json_encode(["is_admin" => $isAdmin]);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? null;

    if ($action === "login") {
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";

        if ($username === "admin" && $password === "password123") {
            $_SESSION["is_admin"] = true;
            $response = ["success" => true, "message" => "Connexion réussie.", "redirect" => "admin_dashboard.html"];
        } else {
            $response["message"] = "Identifiants invalides.";
        }
    } elseif ($action === "logout") {
        session_destroy();
        $response = ["success" => true, "message" => "Déconnexion réussie.", "redirect" => "formulaire.html"];
    } elseif ($action === "submit_form") {
        $name = htmlspecialchars($_POST["name"] ?? "");
        $age = intval($_POST["age"] ?? 0);
        $region = htmlspecialchars($_POST["region"] ?? "");
        $satisfaction = htmlspecialchars($_POST["satisfaction"] ?? "");

        if ($name && $age >= 16 && $age <= 100 && $region && $satisfaction) {
            $response = ["success" => true, "message" => "Merci d'avoir répondu à l'enquête !"];
        } else {
            $response["message"] = "Champs obligatoires manquants ou invalides.";
        }
    } else {
        $response["message"] = "Action non reconnue.";
    }
}

echo json_encode($response);
