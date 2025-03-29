<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UGBvote</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Tienne&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Audiowide&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Aclonica&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />



    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/inscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.3-dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/systemeDeVote.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header-footer.css') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('jquery/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('jquery/form-validation.js') }}"></script>

    <!-- <title>UGBvote</title> -->
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

                            <div class="info">
                            </div>
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

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 d-none d-md-block rounded">
                <img src="images/urne.png" alt="image" class="rounded img-fluid urne h-100 w-100 object-fit-cover">
            </div>
            <div class="col-md-8 col-12">
                <div id="alert"></div>
                <h1 class="text text-center">Inscrivez-Vous !</h1>
                <form action="{{route('ajouterEtudiants')}}" id="inscriptionForm" method="post" novalidate name="formulaire" class="p-4 shadow rounded bg-white">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Entrez votre prénom</label>
                            <input type="text" name="prenom" class="form-control" id="prenom" value="{{ old('prenom') }}" required>
                            @error('prenom') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Entrez votre nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required>
                            @error('nom') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Entrez votre e-mail</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ufr" class="form-label">Sélectionnez votre UFR</label>
                        <select name="ufr" id="ufr" class="form-select">
                            <option value="sciences">Sciences et Technologies</option>
                            <option value="lettres">Lettres et Sciences Humaines</option>
                            <option value="droit">Droit</option>
                            <option value="economie">Économie et Gestion</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Entrez votre mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="confpassword" class="form-label">Confirmez votre mot de passe</label>
                        <input type="password" name="password_confirmation" id="confpassword" class="form-control" required>
                    </div>

                    <div class="row g-3">
                        <div class="col">
                            <button type="submit" class="container-fluid confirm-button">
                                <span class="button-text">Valider</span>
                                <div class="icon-container">
                                    <img alt="icon" class="check-square" src="{{asset('image/user_icons/check-square0.svg') }}" />

                                </div>
                            </button>
                        </div>
                        <div class="col">
                        <button type="reset" class="container-fluid confirm-button-annuler">
                                <span class="button-text">Annuler</span>
                                
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <p>Avez-vous déjà un compte? <a href="{{ route('login') }}">Connectez-vous</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>


</body>

<!-- footer -->
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