<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UGBvote</title>
    <link href="https://fonts.googleapis.com/css?family=Audiowide&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Aclonica&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />


    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.3-dist/css/bootstrap.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/systemeDeVote.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detailListe.css') }}">


    <!-- <link href="css/styles.css" rel="stylesheet" /> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
                <div class="liens-speudo collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav liens d-flex justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('election',['id'=>$etudiant->ufr_id]) }}">
                                <div class="frame-4">
                                    <div class="elections">Élections</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('resultat',['id'=>$etudiant->ufr_id]) }}">
                                <div class="frame-5">
                                    <div class="resultats">Résultats</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- Pseudo -->
                    <div class="pseudo me-5 justify-content-end">
                        <div class="frame-36">
                            <div class="avatar-block">
                                <div class="avatar">
                                    <div class="initials">V</div>
                                </div>
                                @if(isset($etudiant))
                                <div class="info">
                                    <div class="title text-capitalize">{{ $etudiant->prenom }}</div>
                                    <div class="description text-uppercase">{{ $etudiant->nom }}</div>
                                </div>
                                @endif
                            </div>
                        </div>


                        <!-- Image cliquable avec confirmation pour se déconnecter -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <!-- Formulaire de déconnexion caché -->

                            <!-- Image cliquable avec confirmation pour se déconnecter -->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <div class="frame-93 ms-3">
                                    <img alt="img" class="log-out" src="{{ asset('image/user_icons/log-out0.svg') }}" />
                                </div>
                            </a>

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

<body class="">
    <!-- contenu -->


    <div class=" d-flex m-3" id="wrapper">

        <!-- Sidebar-->
        <div class="border-end bg-white " id="sidebar-wrapper">
            <!-- <div class="sidebar-heading border-bottom bg-light fw-bold text-center">  Membres :</div> -->
            <div class="list-group list-group-flush">
                <ul>
                      @foreach($membres as $membre)    
                    <li class="list-group-item list-group-item-action list-group-item-light p-3 fw-bold text-capitalize ">{{ $membre->etudiant->prenom }}  <span class="text-capitalize">{{ $membre->etudiant->nom }}</span> </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper m-3 ">
            <!-- Top navigation-->
            <button type="button" class="btn btnmember  btn-outline-dark  py-3  fw-bold m-3" id="sidebarToggle">Membres de la liste </button>
            <!-- Page content-->
            <div class=" container-fluid  mx-auto my-auto">
                <div class="col m-3 p-3">
                    <h1 class="mt-4"> {{ $liste->name_list }} : <span class="name-list fw-bold ">{{ $liste->titre }} </span> </h1>
                    <p class="text-programme mx-auto my-auto">{{ $liste->programme }}</p>
                </div>
            </div>
        </div>


    </div>

    <div class="button-wrapper" action>
        <a href="{{ route('systemevote') }}" class="text-decoration-none">
            <button class="confirm-button">
                <span class="button-text ">JE VOTE</span>
                <div class="icon-container">

                    <img alt="icon" class="check-square" src="{{asset('image/user_icons/check-square0.svg') }}" />

                </div>
            </button>
        </a>
    </div>
  


    <!-- Modal de confirmation de déconnexion -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmer la déconnexion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmLogout">Se déconnecter</button>
                </div>
            </div>
        </div>
    </div>


    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.getElementById('confirmLogout').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    </script>

      <!-- Core theme JS-->
      <script src="{{ asset('js/scripts.js') }}"></script>
</body>


<!-- footer  -->
<footer class="footer container-fluid">
    <div class="row align-items-center text-center text-md-start">

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
        <div class="col-md-4 text-center">
            <p class="_2025-ugb-vote">© 2025 UGBVote</p>
        </div>

        <!-- Liens utiles -->
        <div class="col-md-4 text-center">
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