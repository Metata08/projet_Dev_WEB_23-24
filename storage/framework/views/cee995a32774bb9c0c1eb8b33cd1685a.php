<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UGB Vote - Connexion</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Liens pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <!-- Styles personnalisés -->
    <style>
        .text-brown { color:rgb(143, 101, 71); } /* Marron */
        .bg-brown { background-color:rgb(143, 101, 71); } /* Fond marron */
        .btn-brown { background-color:rgb(143, 101, 71); color: white; } /* Bouton marron */
        .btn-brown:hover { background-color rgb(143, 101, 71); } /* Effet au survol */
    
    .container {
    max-width: 95%; /* Augmente la largeur du container */
            }
    .logo-rounded {
    border-radius: 50% / 10%; /* Arrondi en hauteur, droit en largeur */
}

.vote-img {
    max-width: 30%; /* Réduit la largeur de l’image */
    height: auto; /* Garde les proportions */
}
/* Assurez-vous que l'image occupe toute la largeur du parent */
.nav-bar-img {
    width: 100%;  /* S'assure que l'image prend toute la largeur de son conteneur */
    height: auto;
    display: block;
}

/* Positionnement du texte au centre */
.navbar-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Pour centrer exactement le texte */
    color:  rgb(131, 86, 1); /* Assurez-vous que le texte est visible */
    font-size: 4vw; /* Taille de police basée sur la largeur du viewport */
    font-weight: bold; /* Ajoutez du gras si vous voulez */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Ombre du texte pour une meilleure lisibilité sur des images claires */
}

    
    
/* Ajout de media queries pour affiner l'apparence sur des écrans plus petits */
@media (max-width: 768px) {
    .navbar-text {
        font-size: 6vw; /* Augmente légèrement la taille du texte sur les petits écrans */
    }
}

@media (max-width: 480px) {
    .navbar-text {
        font-size: 8vw; /* Réduit le texte sur les très petits écrans pour qu'il ne dépasse pas */
    }
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

    </style>
</head>
<body class="bg-light">

    <!-- Header -->
    <header class="bg-brown text-white py-3">
    <div class="container-fluid"> <!-- Utiliser container-fluid pour occuper toute la largeur -->
        <div class="d-flex align-items-center">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo UGB" height="95" class="ms-0 logo-rounded "> <!-- Supprime tout margin -->
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


    <!-- Contenu principal -->
    <div class="row">
    <!-- Partie gauche : Texte et image réduite -->
    <div class="col-md-5 text-center">
       <!-- <h2 class="fw-bold text-brown"> <span class="text-danger"></span></h2>  -->
        <img src="<?php echo e(asset('images/vote.png')); ?>" alt="Vote" class="img-fluid my-3 vote-img">
        <p class="fw-bold text-brown">Chaque vote <span class="text-primary">compte</span>. Mobilisons-nous !</p>
    </div>

    <!-- Partie droite : Formulaire élargi -->
    <div class="col-md-6 position-relative">
    <!-- Titre au-dessus du formulaire -->
    <div class="position-absolute top-0 start-50 translate-middle-x bg-white text-brown px-4 py-6 rounded-3 shadow">
        <h3 class="mb-0">Connectez-Vous !</h3>
    </div>

    <div class="card p-4 h-95 d-flex flex-column justify-content-center border border-dark rounded-3 shadow mt-5 px-4 py-6" style="margin-top: 250px;">

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3 text-center">
                <label for="email" class="form-label fw-bold">E-mail</label>
                <input type="email" class="form-control form-control-lg border border-dark rounded-3 mx-auto" style="max-width: 60%; height: 40px;" id="email" name="email" required>
            </div>
            <div class="mb-3 text-center">
                <label for="password" class="form-label fw-bold">Mot de passe</label>
                <input type="password" class="form-control form-control-lg border border-dark rounded-3 mx-auto" style="max-width: 60%; height: 40px;" id="password" name="password" required>
            </div>

            <!-- Mot de passe oublié aligné à droite -->
            <div class="d-flex justify-content-end mb-3 pe-3">
                <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none">Mot de passe oublié ?</a>
            </div>

            <!-- Bouton connexion de taille moyenne -->
            <div class="text-center">
                <button type="submit" class="btn btn-brown btn-md w-25 border border-dark rounded-3">Connexion</button>
            </div>
        </form>

        <!-- Inscription centrée en dessous -->
        <p class="mt-3 text-center">
            Vous n’avez pas de compte ? <a href="<?php echo e(route('register')); ?>">Inscrivez-vous</a>
        </p>
    </div>
</div>







    <!-- Footer -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /home/anta/Bureau/framwork/voteugb/resources/views/auth/login.blade.php ENDPATH**/ ?>