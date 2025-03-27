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
  <!-- voter pour votre reppresentant  -->
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

  <!-- le liste a voter  -->

  <article class="voting-card-wrapper d-flex justify-content-center align-items-center py-5">
    <div class="voting-card container p-4 shadow rounded">
      <div
        class="card-header text-white rounded p-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
        <figure class="logo-container text-center mb-3 mb-md-0">
          <p class="logo-text fw-bold">Logo Liste</p>
        </figure>
        <div class="title-section text-center text-md-start">
          <h2 class="list-title fw-bold">NOM DE LA LISTE</h2>
        </div>
        <div class="image-container text-center">
          <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Logo" class="list-image img-fluid">
        </div>
      </div>

      <section class="progress-section">
        <div class="progress-container">
          <div class="progress-bar "></div>
          <p class="progress-text text-center text-nowrap ">42% (108 votes)</p>
        </div>
      </section>
      <footer class="confirmation-section">
        <div class="button-wrapper">
          <button class="confirm-button">
            <span class="button-text">CONFIRMER</span>
            <div class="icon-container">

              <img alt="icon" class="check-square" src="{{asset('image/user_icons/check-square0.svg') }}}" />

            </div>
          </button>
        </div>
        <p class="warning-text">
          <strong>Attention</strong>:votre vote est definitif et ne poura pas être
          modifié !
        </p>
      </footer>
    </div>
  </article>

  <!-- resutat en direct  -->

  <div class="results-container container-fluid ">
    <h1 class="results-title text-nowrap">Résultat en temps réel</h1>
    <p class="vote-count text-nowrap">Total des votes : <span class="fw-bold" id="vote-total">256</span></p>
  </div>

  <!-- list  -->

  <div class="row">
    <!-- premier -->
    <div class="col voting-card-wrapper d-flex justify-content-center align-items-center py-5">

      <div class="voting-card container  p-4 shadow rounded">
        <div
          class="card-header2 text-white rounded p-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
          <figure class="logo-container text-center mb-3 mb-md-0">
            <p class="logo-text fw-bold">Logo Liste</p>
          </figure>
          <div class="title-section text-center text-md-start">
            <h2 class="list-title fw-bold">NOM DE LA LISTE</h2>
          </div>
          <div class="image-container text-center">
            <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Logo" class="list-image img-fluid">
          </div>
        </div>

        <section class="progress-section">
          <div class="progress-container">
            <div class="progress-bar ">
            </div>
            <p class="progress-text text-center text-nowrap ">42% (108 votes)</p>
          </div>
        </section>

      </div>
    </div>

    <!-- deuxieme -->
    <div class="col voting-card-wrapper d-flex justify-content-center align-items-center py-5">

      <div class="voting-card container  p-4 shadow rounded">
        <div
          class="card-header2 text-white rounded p-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
          <figure class="logo-container text-center mb-3 mb-md-0">
            <p class="logo-text fw-bold">Logo Liste</p>
          </figure>
          <div class="title-section text-center text-md-start">
            <h2 class="list-title fw-bold">NOM DE LA LISTE</h2>
          </div>
          <div class="image-container text-center">
            <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Logo" class="list-image img-fluid">
          </div>
        </div>

        <section class="progress-section">
          <div class="progress-container">
            <div class="progress-bar2 ">
            </div>
            <p class="progress-text text-center text-nowrap ">28% (72 votes)</p>
          </div>
        </section>

      </div>
    </div>


    <!-- 3eme -->

    <div class=" col voting-card-wrapper d-flex justify-content-center align-items-center py-5">

      <div class="voting-card container  p-4 shadow rounded">
        <div
          class="card-header2 text-white rounded p-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
          <figure class="logo-container text-center mb-3 mb-md-0">
            <p class="logo-text fw-bold">Logo Liste</p>
          </figure>
          <div class="title-section text-center text-md-start">
            <h2 class="list-title fw-bold">NOM DE LA LISTE</h2>
          </div>
          <div class="image-container text-center">
            <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Logo" class="list-image img-fluid">
          </div>
        </div>

        <section class="progress-section">
          <div class="progress-container">
            <div class="progress-bar3 ">
            </div>
            <p class="progress-text text-center text-nowrap ">38% (76 votes)</p>
          </div>
        </section>

      </div>
    </div>
  </div>


  <!-- footer  -->




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