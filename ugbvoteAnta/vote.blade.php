<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UGB Vote</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Liens pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles-vote.css') }}">
   
</head>
<body>
<header class="header">
       <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UGB" height="95" class="ms-0 logo-rounded "> <!-- Supprime tout margin -->
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
            <img src="{{ asset('images/nav-bar.png') }}" alt="Navigation" class="nav-bar-img">

            <!-- Texte centré entre les icônes -->
            <p class="navbar-text position-absolute top-50 start-50 translate-middle">
               Election du representant des etudiants
            </p>
        </div>
    </div>
</div>

 <!-- LE CONTENU -->

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



                                <img src="{{ asset('images/logoliste.png') }}" alt="Vote" height="50">
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
                                <img src="{{ asset('images/logoliste.png') }}" alt="Vote" height="50">
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
                                <img src="{{ asset('images/logoliste.png') }}" alt="Vote" height="50">
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

 <!-- FIN CONTENU -->

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