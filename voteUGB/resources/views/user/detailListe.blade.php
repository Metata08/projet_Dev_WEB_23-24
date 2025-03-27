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


    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.3-dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/systemeDeVote.css') }}">
    <link href="css/styles.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        a,
        button,
        input,
        select,
        h1,
        h2,
        h3,
        h4,
        h5,
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: none;
            text-decoration: none;
            background: none;

            -webkit-font-smoothing: antialiased;
        }

        menu,
        ol,
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
    </style>
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

        </div>

    </header>

<body class="">

<div class="d-flex m-3" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white " id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light fw-bold">Person_Name TETE </div>
                <div class="list-group list-group-flush">
                    <ul>
                        <li class="list-group-item list-group-item-action list-group-item-light p-3">Membre_OF_List</li>
                        <li class="list-group-item list-group-item-action list-group-item-light p-3">Membre_OF_List</li>
                        <li class="list-group-item list-group-item-action list-group-item-light p-3">Membre_OF_List</li>
                        <li class="list-group-item list-group-item-action list-group-item-light p-3">Membre_OF_List</li>
                        <li class="list-group-item list-group-item-action list-group-item-light p-3">Membre_OF_List</li>

                    </ul>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper m-3 ">
                <!-- Top navigation-->
                <!-- <button class="btn btn-member  py-3  fw-bold m-3 " id="sidebarToggle">Membres</button> -->
                <button type="button" class="btn btn-member py-3  fw-bold m-3   btn-outline  "  id="sidebarToggle">Membres</button>
                <!-- Page content-->
                <div class="container-fluid">   
                    <h1 class="mt-4">Titre du programme: <span class="name-list fw-bold text-primary">Sama list </span> </h1>
                    <p class="fw-bold slogan">The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
                    <p class="container">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit quos veniam exercitationem quae? Ea corrupti, eveniet eos, totam saepe est optio, dolor cupiditate dolorum laboriosam voluptatibus nostrum consequuntur. Eum, ipsum.
                        Laborum et dolor veniam dolore ullamco culpa et labore sunt adipisicing. Eu nulla et ut incididunt consequat reprehenderit id mollit enim ipsum fugiat consectetur est. Velit dolore non enim nulla enim. In nostrud Lorem velit veniam eu sunt do duis quis. Proident commodo nostrud do eiusmod officia consequat culpa.

                        Consequat labore adipisicing eu ullamco ipsum dolore est duis aute anim irure proident pariatur. Officia ex reprehenderit id veniam commodo sit elit magna cupidatat cupidatat enim ad nisi eiusmod. Mollit consectetur ipsum Lorem excepteur do proident cillum ex enim elit enim fugiat tempor. Voluptate qui labore ipsum officia. Consectetur laborum aliqua et culpa consectetur mollit Lorem adipisicing esse enim.

Tempor nostrud sit ea ut sint ullamco commodo. Nulla amet mollit qui minim. Id est id sint id dolor pariatur. Cupidatat sint non esse veniam voluptate ut Lorem enim nisi aliquip. Amet et Lorem enim aliquip. Laboris do exercitation mollit id eiusmod commodo ut incididunt occaecat velit sunt. Ut laboris mollit qui minim exercitation deserunt commodo esse.

Lorem ipsum laboris eiusmod dolore do anim ea magna nulla culpa laborum laborum fugiat ut. Qui occaecat ad anim ea aute voluptate exercitation nostrud ipsum exercitation adipisicing. Aliquip Lorem proident aliqua quis ipsum et adipisicing tempor consectetur voluptate. Quis est ut dolore Lorem et.

Deserunt ullamco aliquip et incididunt est cupidatat sint nostrud consequat. Elit est pariatur ipsum ullamco nisi sit amet cillum exercitation eiusmod. Eiusmod ipsum nulla ea adipisicing aute. Minim proident officia commodo eiusmod eu Lorem tempor Lorem laboris. Excepteur enim adipisicing adipisicing excepteur esse.

Ex nisi nulla laboris aliquip. Fugiat aliquip elit culpa cupidatat do. Et labore non pariatur nulla incididunt nostrud ea ea labore in quis. Ad et proident magna irure mollit dolor aute laborum ullamco reprehenderit.

Eu nulla duis dolore ea. Exercitation veniam incididunt minim reprehenderit incididunt cillum veniam eiusmod nulla sint pariatur pariatur. Voluptate fugiat dolore eu et fugiat laboris ex fugiat. Cillum dolor cupidatat aute culpa enim aliqua. Sint eiusmod eu excepteur aute. Ullamco nisi cupidatat reprehenderit excepteur magna ipsum irure ex amet voluptate id. Quis id velit commodo ullamco sint amet nulla ea duis fugiat fugiat duis officia aliquip.

Eiusmod fugiat sunt ullamco adipisicing est elit aute incididunt cillum exercitation. Fugiat ea cillum esse nostrud non quis culpa ea cupidatat cupidatat tempor. Ut laboris dolore aliquip laboris non ad magna elit.

Nisi dolor aliquip anim in laboris reprehenderit do ullamco labore velit amet exercitation. Qui commodo dolor reprehenderit dolore aliqua. Cupidatat magna cillum nulla sunt officia labore fugiat irure exercitation.

Quis fugiat id ad eiusmod duis adipisicing ut culpa proident in. Id ullamco commodo sit ea aliquip cupidatat aliqua consectetur cupidatat mollit et sunt est tempor. Id qui in ex sint id nisi sint ad occaecat. Nostrud sint duis dolore labore enim est ea do veniam aliqua occaecat pariatur ad. Tempor do minim non proident mollit qui commodo. Esse ad id dolor consequat esse ut excepteur deserunt.

Proident eiusmod anim enim ut incididunt pariatur officia sunt in laborum elit qui. Quis fugiat do elit anim qui laborum commodo aliquip commodo in mollit dolor voluptate. Consequat sit incididunt cupidatat laboris ea consequat ipsum laborum amet occaecat do id. Culpa nulla voluptate ipsum ullamco. Pariatur laboris id nostrud velit labore magna minim amet voluptate sunt amet esse sit. Elit pariatur nostrud ad proident. In Lorem laboris non dolor cillum adipisicing ex.

Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga illo porro dicta accusantium ipsam, vero eaque repellat deleniti possimus pariatur suscipit temporibus ullam, quos sit dignissimos id aliquid quas doloremque.                    </p>
                </div>
            </div>
        </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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