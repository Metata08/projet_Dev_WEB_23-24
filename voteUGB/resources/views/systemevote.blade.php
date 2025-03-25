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
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
</head>
<header>
  <headed class="container ">
  <div class="header-principal w-100">
  <nav class="navbar navbar-expand-lg ">
    <!-- Logo -->
    <div class="frugb-vote me-auto">
      <a href="#accueil">
        <img class="ugb-vote-1" src="{{asset('image/user_image/logoUBGvote.png')}}" />
      </a>
    </div>

    <!-- Bouton toggle pour les petits écrans -->
    <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Liens et pseudo -->
    <div class="liens-speudo collapse navbar-collapse justify-content-end " id="navbarNav">
      <ul class="navbar-nav liens me-5 d-flex">
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
      <div class="pseudo me-5 justify-content-center ">
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
          <img class="log-out" src="{{ asset('image/user_icons/log-out0.svg') }}" />
        </div>
      </div>
    </div>
  </nav>
</div>
 </headed>
</header>

<body>


</body>

</html>