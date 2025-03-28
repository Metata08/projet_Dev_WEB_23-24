<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description1" content="Plateforme de vote en ligne pour l'élection des représentants étudiants de l'UGB">

    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Tienne&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/accueil.css') }}">

    <title>UGBvote</title>
    <link href="https://fonts.googleapis.com/css?family=Audiowide&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Aclonica&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.3-dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/systemeDeVote.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<!-- header -->
<header class="">
    <div class="header-principal w-100 ">
        <nav class="navbar navbar-expand-lg ">
            <!-- Logo -->
            <div class="frugb-vote me-auto">
                <a href="#accueil">
                    <img alt="img" class="ugb-vote-1" src="{{ asset('image/user_image/logoUBGvote.png') }}" />
                </a>
            </div>

            <!-- Bouton toggle pour les petits écrans -->
            <button type="button" title="toggle" class="navbar-toggler d-lg-none ms-auto" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Liens et pseudo -->
            <div class="liens-speudo collapse navbar-collapse justify-content-end " id="navbarNav">
                <ul class="navbar-nav  liens  d-flex justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <div class="frame-4">

                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <div class="frame-5">

                            </div>
                        </a>
                    </li>
                </ul>

                <!-- Pseudo à droite -->
                <div class="pseudo me-5 justify-content-end">
                    <div class="frame-36">
                        <div class="avatar-block">

                            <a href="{{ route('login') }}"  class="text-decoration-none">
                            <button class="confirm-button">
                                <span class="button-text">Se Connecter</span>
                                <div class="icon-container">

                                    <img alt="icon" class="check-square" src="{{asset('image/user_icons/log-in.png') }}" />

                                </div>
                            </button>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
        <!-- image-header -->



        <div class="imageHeader">
            <img alt="img" class="design-sans-titre-1" src="{{ asset('image/user_image/image-header.png') }}" />
            <div class="election-du-repr-sentant-des-tudiants">
                Election du représentant des étudiants
            </div>
        </div>

    </div>

</header>
<!-- contenu -->

<body>

    <main class=" container-fluid " role="main">
        <section aria-labelledby="process-title">
            <div class="text-center p-3 mt-3">
                <div class="section-image">
                    <img src="images/ins.jpeg" alt="Processus d'inscription" class="active" loading="lazy">
                    <img src="images/conn.jpeg" alt="Page de connexion" loading="lazy">
                    <img src="images/choix_can.jpeg" alt="Choix des candidats" loading="lazy">
                    <img src="images/vote_can.png" alt="Interface de vote" loading="lazy">
                    <img src="images/resultat.png" alt="Résultats du vote" loading="lazy">
                </div>
            </div>

            <div class="content-section container-fluid  addEventListener  ">
                <div class="explication">
                    <div class="section1">
                        <div class="text-center p-3">
                            <div class="number" aria-hidden="true">1</div>
                            <div class="card1">
                                <h2>Connexion</h2>
                                <div class="description1">Accédez à votre compte</div>
                            </div>
                        </div>
                        <div class="text-center p-3">
                            <div class="number" aria-hidden="true">2</div>
                            <div class="card1">
                                <h2>Choisir une liste</h2>
                                <div class="description1">Vous avez le choix entre ces listes</div>
                            </div>
                        </div>
                    </div>
                    <div class="section2">
                        <div class="text-center p-3">
                            <div class="number" aria-hidden="true">3</div>
                            <div class="card1">
                                <h2>Voter</h2>
                                <div class="description1">Exprimez votre choix</div>
                            </div>
                        </div>
                        <div class="text-center p-3">
                            <div class="number" aria-hidden="true">4</div>
                            <div class="card1">
                                <h2>Résultats</h2>
                                <div class="description1">Découvrez les résultats</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="slogan">
                    <h2 class="texte">Votre avenir, votre voix.</h2>
                    <p>Élisez des représentants engagés pour vous !</p>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.section-image img');
            let currentIndex = 0;

            function showNextImage() {
                images.forEach(img => img.classList.remove('active'));
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.add('active');
            }

            // Démarrer l'image
            let intervalImage = setInterval(showNextImage, 5000);

            // Pause au survol pour meilleure UX
            const image = document.querySelector('.section-image');
            image.addEventListener('mouseenter', () => clearInterval(intervalImage));
            image.addEventListener('mouseleave', () => {
                clearInterval(intervalImage);
                intervalImage = setInterval(showNextImage, 5000);
            });

            // Gestion du touch pour mobile
            let touchStartX = 0;
            let touchEndX = 0;

            image.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
                clearInterval(intervalImage);
            }, {
                passive: true
            });

            image.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                intervalImage = setInterval(showNextImage, 3000);
            }, {
                passive: true
            });

            function handleSwipe() {
                const threshold = 50;
                if (touchStartX - touchEndX > threshold) {
                    // Swipe gauche
                    showNextImage();
                } else if (touchEndX - touchStartX > threshold) {
                    // Swipe droit
                    images.forEach(img => img.classList.remove('active'));
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                    images[currentIndex].classList.add('active');
                }
            }
        });
    </script>
</body>
<!-- footer -->
<footer class="footer container-fluid">
    <div class="row align-items-center text-center p-3 text-md-start">

        <!-- Logo et réseaux sociaux -->
        <div class="col-md-4 d-flex flex-column align-items-center">
            <div class=" logo-footer ">
                <div class="frugb-vote">
                    <a href="#accueil">
                        <img alt="img" class="ugb-vote-1" src="{{ asset('image/user_image/logoUBGvote.png') }}" />
                    </a>
                </div>
                <div class="button-list d-flex justify-content-center ">
                    <img class="img-fluid" src="image/user_icons/imasex.png" alt="Twitter">
                    <img class="img-fluid" src="{{ asset('image/user_icons/logo-instagram0.svg') }}" alt="Instagram">
                    <img class="img-fluid" src="{{ asset('image/user_icons/logo-you-tube0.svg') }}" alt="YouTube">
                    <img class="img-fluid" src="{{ asset('image/user_icons/linked-in0.svg') }}" alt="LinkedIn">
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="col-md-4 text-center p-3">
            <p class="_2025-ugb-vote">© 2025 UGBVote</p>
        </div>

        <!-- Liens utiles -->
        <div class="col-md-4 text-center p-3">
            <div class="lienutiles align-items-start">
                <p class="lien-utiles-www-ugb-sn-portail-ugbnumerique-sn">
                    <strong>Lien Utiles</strong><br>
                    <a href="https://www.ugb.sn" target="_blank">www.ugb.sn</a><br>
                    <a href="https://portail.ugbnumerique.sn" target="_blank">portail.ugbnumerique.sn</a>
                </p>
            </div>
        </div>

    </div>
</footer>

</html>