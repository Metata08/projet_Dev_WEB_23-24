<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UGB Vote</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Liens pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles-vote.css')); ?>">

    <style>
      
       /* Utilisation de flexbox pour positionner le footer en bas */
 html, body {
    height: 100%;
    margin: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    display: flex;
    flex-direction: column;
}

.header {
    background-color: rgb(182, 137, 91) !important;
    padding: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 3px solid brown;
}

.header img {
    height: 80px;
}

.logo-rounded {
    border-radius: 50% / 10%; /* Arrondi en hauteur, droit en largeur */
}

.user-info {
    display: flex;
    align-items: center;
    gap: 20px; /* Ajustez cet espacement comme vous le souhaitez */
}

.nav-links a {
    color: black;
    font-weight: bold;
    text-decoration: none;
    margin-right: 10px; /* Ajuste l'espace entre le dernier lien et l'avatar */
}



.nav-links a:hover {
    color: brown;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.avatar {
    width: 40px;
    height: 40px;
    background-color: rgb(85, 60, 12);
    color: white;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.container {
    padding: 10px;
    flex-grow: 1; /* Permet de pousser le footer en bas si le contenu est insuffisant */
}

.containere {
    max-width: 100%;
}

/* Assurez-vous que l'image occupe toute la largeur du parent */
/* Assurez-vous que l'image occupe toute la largeur du parent */
.nav-bar-img {
    width: 100%;  /* L'image prendra toute la largeur de son conteneur */
    height: auto;  /* Maintient le ratio de l'image */
    display: block; /* Retire l'espace en bas de l'image */
}

/* Positionnement du texte centré au milieu de l'image */
.navbar-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);  /* Pour centrer exactement le texte */
    color: rgb(131, 86, 1);  /* Assurez-vous que le texte est visible */
    font-size: 4vw;  /* Taille du texte basée sur la largeur du viewport */
    font-weight: bold;  /* Ajoute du gras au texte */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);  /* Ombre du texte pour une meilleure lisibilité */
}

/* Réduire la taille du texte sur des écrans plus petits */
@media (max-width: 768px) {
    .navbar-text {
        font-size: 6vw;  /* Augmente légèrement la taille du texte sur les écrans plus petits */
    }
}

@media (max-width: 480px) {
    .navbar-text {
        font-size: 8vw;  /* Réduit la taille du texte sur les très petits écrans */
    }
}


.card {
    background-color: rgb(131, 86, 1);
    color: white;
    border-radius: 10px;
    overflow: hidden;
}

.bg-light-custom {
    background-color: rgb(184, 182, 181);
    color: white !important;
}

.card .card-body {
    background-color: rgb(184, 182, 181);
}

.badge {
    background-color: #b0b0b0;
    color: black;
}

.btn-voter {
    background-color: #b36b00;
    color: white;
    border: none;
    text-align: center;
}

.btn-voter:hover {
    background-color: brown;
}

.footer {
    background-color: rgb(184, 182, 181);
    text-align: center;
    padding: 20px 10px;
    border-top: 3px solid brown;
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer .social-icons a {
    color: black;
    font-size: 30px;
    margin: 0 10px;
    transition: color 0.3s ease;
}

.footer .social-icons a:hover {
    color: grey;
}

.footer .footer-links a {
    color: black;
    text-decoration: none;
}

.footer .footer-links a:hover {
    color: grey;
}

/* Ajout de couleur marron pour le titre */
.text-brown {
    color: #6F4F37; /* Marron */
}

/* Ajout d'un style pour "Voir programme" */
.btn-light-pink {
    background-color: rgb(180, 137, 137);
    color: black;
}

/* Ajuster la hauteur du bouton voter */
.btn-brown {
    background-color: #6F4F37;
    color: white;
}
    </style>
</head>
<body>
<header class="header">
       <div class="d-flex align-items-center">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo UGB" height="95" class="ms-0 logo-rounded "> <!-- Supprime tout margin -->
        </div>
    
    <div class="d-flex align-items-center ms-auto" style="flex-grow: 1; justify-content: flex-end;">
        <!-- Liens -->
        <nav class="nav-links d-flex gap-3">
            <a href="#">Élections</a>
            <a href="#">Résultats</a>
        </nav>

        <!-- Avatar et info utilisateur -->
        <div class="user-info d-flex align-items-center gap-3">
            <div class="avatar">A</div>
            <div><span>Prénom</span></div>
            <div><span>Nom</span></div>
            <i class="fas fa-cog" style="color: black;"></i>
        </div>
    </div>
</header>





  <!-- Barre de navigation séparée de la barre principale -->
<div class="containere">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center position-relative">
            <!-- Image de la barre de navigation -->
            <img src="<?php echo e(asset('images/nav-bar.png')); ?>" alt="Navigation" class="nav-bar-img">

            <!-- Texte centré entre les icônes -->
            <p class="navbar-text position-absolute top-50 start-50 translate-middle">
               Election du representant des etudiants
            </p>
        </div>
    </div>
</div>



    <div class="container mt-5">
        <!-- Titre et durée de l'élection -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h4 class="text-uppercase fw-bold text-brown">Liste des candidats</h4>
                <p class="text-muted" style="color: rgb(128, 90, 90);">Election 2024-2025 -en cours jusqu'au ..,</p>
            </div>
        </div>

        <!-- Cartes -->
        <div class="row">
            <!-- Carte 1 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <!-- Section marron -->
                    <div class="bg-brown text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-light p-4 text-dark border-4">Logo Liste</div>
                            <div class="d-flex flex-column align-items-center">
                            <span class="badge">NOM DE LA LISTE</span>



                                <img src="<?php echo e(asset('images/logoliste.png')); ?>" alt="Vote" height="50">
                            </div>
                        </div>
                    </div>

                    <!-- Bouton voir programme (rose clair) -->
                    <div class="text-center">
                        <button class="btn btn-light-pink border-2 my-2">Voir programme</button>
                    </div>

                    <!-- Section gris clair -->
                    <div class="card-body bg-light-gray text-dark flex-grow-1 d-flex flex-column justify-content-between p-3">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-brown btn-sm">VOTER 👍</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <div class="bg-brown text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-light p-4 text-dark border-4">Logo Liste</div>
                            <div class="d-flex flex-column align-items-center">
                                <span class="badge">NOM DE LA LISTE</span>
                                <img src="<?php echo e(asset('images/logoliste.png')); ?>" alt="Vote" height="50">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-light-pink border-0 my-2">Voir programme</button>
                    </div>

                    <div class="card-body bg-light-gray text-dark flex-grow-1 d-flex flex-column justify-content-between p-3">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-brown btn-sm">VOTER 👍</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 3 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <div class="bg-brown text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-light p-4 text-dark border-4">Logo Liste</div>
                            <div class="d-flex flex-column align-items-center">
                                <span class="badge">NOM DE LA LISTE</span>
                                <img src="<?php echo e(asset('images/logoliste.png')); ?>" alt="Vote" height="50">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-light-pink border-0 my-2">Voir programme</button>
                    </div>

                    <div class="card-body bg-light-gray text-dark flex-grow-1 d-flex flex-column justify-content-between p-3">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-brown btn-sm">VOTER 👍</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="social-icons">
            <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
        <div class="footer-text">
            <p>© 2025 UGBVote</p>
        </div>
        <div class="footer-links">
            <p><a href="https://www.ugb.sn">www.ugb.sn</a></p>
            <p><a href="https://portail.ugbnumerique.sn">portail.ugbnumerique.sn</a></p>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /home/anta/Bureau/framwork/voteugb/resources/views/auth/vote.blade.php ENDPATH**/ ?>