

document.addEventListener('DOMContentLoaded', function () {
    const userMenu = document.getElementById('user-side-menu');

    fetch('../seconnecter/check-session.php')
        .then(response => response.json())
        .then(data => {
            if (data.isLoggedIn) {
                userMenu.innerHTML = `
                    <a href="../sinscrire/logout.php">Se déconnecter</a>
                `;
            } else {
                userMenu.innerHTML = `
                    <a href="../seconnecter/SeConnecter.html">Se connecter</a>
                    <a href="../sinscrire/Sinscrire.html">Créer un compte</a>
                `;
            }
        })
        .catch(error => console.error('Erreur lors de la vérification de session:', error));
});