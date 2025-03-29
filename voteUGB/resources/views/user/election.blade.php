<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UGBvote</title>
    <!-- Liens pour les icônes -->
    <link href="https://fonts.googleapis.com/css?family=Audiowide&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Aclonica&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles-vote.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.3-dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/systemeDeVote.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detailListe.css') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

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
                                <div class="elections">Élections</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <div class="frame-5">
                                <div class="resultats">Résultats</div>
                            </div>
                        </a>
                    </li>
                </ul>

                <!-- Pseudo à droite -->
                <div class="pseudo me-5 justify-content-end">
                    <div class="frame-36">
                        <div class="avatar-block">
                            <div class="avatar">
                                <div class="initials">A</div>
                            </div>
                            <div class="info">
                                <div class="title">Prenom</div>
                                <div class="description">NOM</div>
                            </div>
                        </div>
                    </div>
                    <div class="frame-93 ms-3">
                        <img alt="img" class="log-out" src="{{ asset('image/user_icons/log-out0.svg') }}" />
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


</header>

<body>
    <!-- LE CONTENU -->

    <div class="container-fluid  m-3 p-3">
        <div class="voter">
            <div class="voter-pour-votre-repr-sentant">
                Voter pour votre représentant
            </div>
            <div class="frame-58 d-flex ">
                <div class="election-2024-2025-en-cours-jusqu-au-15-03-2025">
                    <span>Election <span class="fw-bold">2024-2025 </span> - En cours jusqu’au<span class="fw-bold">
                            15/03/2025</span></span>
                </div>
            </div>
        </div>
    </div>


    <div class="container " id="custom-cards">
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch">
            <!-- card 1 -->
            <div class="col">
                <div class="vot-card-container">
                    <div class="vot-card">
                        <header class="carte-header  ">
                            <div class="logo-carte">Logo Liste</div>
                            <div class="liste-info">
                                <h2 class="list-nom">NOM DE LA LISTE</h2>
                                <div class="vote-icon-wrapper">
                                    <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Vote icon" />
                                </div>
                            </div>
                        </header>
                        <nav class="programme-nav">
                            <a href="{{ route('detailListe') }}"><button class="programme-button">Voir programme</button></a>
                        </nav>
                        <footer class="vote-actionn">
                            <a href="{{ route('systemevote') }}" class="text-decoration-none">
                                <button class="confirm-button">
                                    <span class="button-text ">VOTER</span>
                                    <div class="icon-container">

                                        <img alt="icon" class="check-square" src="{{asset('image/user_icons/check-square0.svg') }}" />

                                    </div>
                                </button>
                            </a>
                        </footer>
                    </div>
                </div>
            </div>

            <!-- card 2 -->
            <div class="col">
                <div class="vot-card-container">
                    <div class="vot-card">
                        <header class="carte-header  ">
                            <div class="logo-carte">Logo Liste</div>
                            <div class="liste-info">
                                <h2 class="list-nom">NOM DE LA LISTE</h2>
                                <div class="vote-icon-wrapper">
                                    <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Vote icon" />
                                </div>
                            </div>
                        </header>
                        <nav class="programme-nav">
                            <a href="{{ route('detailListe') }}"><button class="programme-button">Voir programme</button></a>
                        </nav>
                        <footer class="vote-actionn">
                            <a href="{{ route('systemevote') }}" class="text-decoration-none">
                                <button class="confirm-button">
                                    <span class="button-text">VOTER</span>
                                    <div class="icon-container">

                                        <img alt="icon" class="check-square" src="{{asset('image/user_icons/check-square0.svg') }}" />

                                    </div>
                                </button>
                            </a>
                        </footer>
                    </div>
                </div>
            </div>

            <!-- card 3 -->
            <div class="col">
                <div class="vot-card-container">
                    <div class="vot-card">
                        <header class="carte-header  ">
                            <div class="logo-carte">Logo Liste</div>
                            <div class="liste-info">
                                <h2 class="list-nom">NOM DE LA LISTE</h2>
                                <div class="vote-icon-wrapper">
                                    <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Vote icon" />
                                </div>
                            </div>
                        </header>
                        <nav class="programme-nav">
                            <a href="{{ route('detailListe') }}"><button class="programme-button">Voir programme</button></a>
                        </nav>
                        <footer class="vote-actionn">
                            <a href="{{ route('systemevote') }}" class="text-decoration-none">
                                <button class="confirm-button">
                                    <span class="button-text">VOTER</span>
                                    <div class="icon-container">

                                        <img alt="icon" class="check-square" src="{{asset('image/user_icons/check-square0.svg') }}" />

                                    </div>
                                </button>
                            </a>
                        </footer>
                    </div>
                </div>
            </div>


        </div>
    </div>



    <!-- FIN CONTENU -->


</body>

<footer class="footer container-fluid">
    <div class="row align-items-center text-center text-md-start">

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
        <div class="col-md-4 text-center">
            <p class="_2025-ugb-vote">© 2025 UGBVote</p>
        </div>

        <!-- Liens utiles -->
        <div class="col-md-4 text-center">
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