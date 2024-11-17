document.addEventListener("DOMContentLoaded", () => {
    // Gestion de l'envoi du formulaire utilisateur
    document.getElementById("survey-form").addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        formData.append("action", "submit_form");

        fetch("formulaire.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error("Erreur lors de l'envoi :", error));
    });

    // Gestion de la connexion admin
    document.getElementById("admin-login-form").addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        formData.append("action", "login");

        fetch("formulaire.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => console.error("Erreur lors de la connexion :", error));
    });

    // Charger les données pour les graphiques
    fetch("formulaire.php?action=get_chart_data")
        .then(response => response.json())
        .then(data => {
            const lieuDeVie = data.find(item => item.thematique === "Lieu de vie")?.reponses || {};
            const qualiteDeVie = data.find(item => item.thematique === "Qualité de vie")?.reponses || {};

            const ctxLieuDeVie = document.getElementById("chart-lieu-de-vie")?.getContext("2d");
            const ctxQualiteDeVie = document.getElementById("chart-qualite-de-vie")?.getContext("2d");

            if (ctxLieuDeVie) {
                new Chart(ctxLieuDeVie, {
                    type: "pie",
                    data: {
                        labels: Object.keys(lieuDeVie),
                        datasets: [{
                            label: "Répartition des lieux de vie",
                            data: Object.values(lieuDeVie),
                            backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: "top" },
                            title: { display: true, text: "Répartition des lieux de vie" },
                        },
                    },
                });
            }

            if (ctxQualiteDeVie) {
                new Chart(ctxQualiteDeVie, {
                    type: "bar",
                    data: {
                        labels: Object.keys(qualiteDeVie),
                        datasets: [{
                            label: "Évaluation de la qualité de vie",
                            data: Object.values(qualiteDeVie),
                            backgroundColor: ["#4CAF50", "#F44336"],
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: true, text: "Évaluation de la qualité de vie" },
                        },
                    },
                });
            }
        })
        .catch(error => console.error("Erreur lors du chargement des données :", error));

    // Gestion de la déconnexion admin
    document.getElementById("logout-form").addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        formData.append("action", "logout");

        fetch("formulaire.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => console.error("Erreur lors de la déconnexion :", error));
    });
});
