<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description1" content="Plateforme de vote en ligne pour l'élection des représentants étudiants de l'UGB">
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
                <a href="{{ route('ugbvote') }}">
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

                            <a href="{{ route('login') }}" class="text-decoration-none">
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
            <!-- carousel -->


            <div class="text-center p-3 mt-3 ">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="  carousel-inner ">
                        <div class="carousel-item  active" data-bs-interval="5000">
                            <img src="{{ asset('image/carousel/inscription.png ') }}" class="d-block w-50 my-auto mx-auto rounded img-fluid" alt="...">
                        </div>
                        <div class="carousel-item " data-bs-interval="5000">
                            <img src="{{ asset('image/carousel/Connecter.png ') }}" class="d-block w-50 my-auto mx-auto rounded img-fluid" alt="...">
                        </div>
                        <div class="carousel-item ">
                            <img src="{{ asset('image/carousel/choisir.png  ') }}" class="d-block w-50 my-auto mx-auto rounded img-fluid" alt="...">
                        </div>
                        <div class="carousel-item " data-bs-interval="5000">
                            <img src="{{ asset('image/carousel/voter.png ') }}" class="d-block w-50 my-auto mx-auto rounded img-fluid" alt="...">
                        </div>
                        <div class="carousel-item " data-bs-interval="5000">
                            <img src="{{ asset('image/carousel/resultats.png') }}" class="d-block w-50 my-auto mx-auto rounded img-fluid" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually text-secondary">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually text-secondary">Suivant</span>
                    </button>
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


</body>
<!-- footer -->
<footer class="footer container-fluid">
    <div class="row align-items-center text-center p-3 text-md-start">

        <!-- Logo et réseaux sociaux -->
        <div class="col-md-4 d-flex flex-column align-items-center">
            <div class=" logo-footer ">
                <div class="frugb-vote">
                    <a href="{{ route('ugbvote') }}">
                        <img alt="img" class="ugb-vote-1" src="{{ asset('image/user_image/logoUBGvote.png') }}" />
                    </a>
                </div>
                <div class="button-list d-flex justify-content-center ">
                    <img class="img-fluid" src="{{ asset('image/user_icons/imasex.png') }}" alt="Twitter">
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
                    <a href="https://www.ugb.sn" class="text-decoration-none" target="_blank">www.ugb.sn</a><br>
                    <a href="https://portail.ugbnumerique.sn" class="text-decoration-none" target="_blank">portail.ugbnumerique.sn</a>

                </p>
            </div>
        </div>

    </div>
</footer>

</html>