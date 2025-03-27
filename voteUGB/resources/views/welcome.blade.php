<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="Plateforme de vote en ligne pour l'élection des représentants étudiants de l'UGB">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Tienne&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/accueil.css') }}">
    
    <title>Vote UGB - Élection des représentants étudiants</title>
</head>
<body>
    <header class="container-fluid">
        <div class="logo">
            <img src="images/logo.png" alt="Logo de l'Université Gaston Berger" loading="lazy">
        </div>
        <div class="connexion">
            <a href="{{url('inscription')}}" aria-label="Se connecter à la plateforme de vote">
                <button class="btn">Se Connecter</button>
            </a>
        </div>
    </header>
    
    <div class="header-container">
        <img src="images/header.jpg" alt="Étudiants de l'UGB" loading="lazy">
        <h1 class="page-title">Élection du représentant des étudiants</h1>
    </div>

    <main class="container" role="main">
        <section aria-labelledby="process-title">
            <div class="text-center mt-3">
                <div class="section-image">
                    <img src="images/ins.jpeg" alt="Processus d'inscription" class="active" loading="lazy">
                    <img src="images/conn.jpeg" alt="Page de connexion" loading="lazy">
                    <img src="images/choix_can.jpeg" alt="Choix des candidats" loading="lazy">
                    <img src="images/vote_can.png" alt="Interface de vote" loading="lazy">
                    <img src="images/resultat.png" alt="Résultats du vote" loading="lazy">
                </div>
            </div>

            <div class="content-section">
                <div class="explication">
                    <div class="section1">
                        <div class="text-center">
                            <div class="number" aria-hidden="true">1</div>
                            <div class="card">
                                <h2>Connexion</h2>
                                <div class="description">Accédez à votre compte</div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="number" aria-hidden="true">2</div>
                            <div class="card">
                                <h2>Choisir une liste</h2>
                                <div class="description">Vous avez le choix entre ces listes</div>
                            </div>
                        </div>
                    </div>
                    <div class="section2">
                        <div class="text-center">
                            <div class="number" aria-hidden="true">3</div>
                            <div class="card">
                                <h2>Voter</h2>
                                <div class="description">Exprimez votre choix</div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="number" aria-hidden="true">4</div>
                            <div class="card">
                                <h2>Résultats</h2>
                                <div class="description">Découvrez les résultats</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="slogan">
                    <h2>Votre avenir, votre voix.</h2>
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
            }, {passive: true});
            
            image.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                intervalImage = setInterval(showNextImage, 3000);
            }, {passive: true});
            
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
</html>
