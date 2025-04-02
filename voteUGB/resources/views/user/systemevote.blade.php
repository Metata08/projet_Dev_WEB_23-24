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
</head>

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
            <a class="nav-link" href="{{ route('election') }}">
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
      <!-- Pseudo à droite -->


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
  <div class="container-fluid m-3 p-3">
    <!-- Votre contenu ici -->
    <div class="voter">
      <div class="voter-pour-votre-repr-sentant">
        Voter pour votre représentant
      </div>
      <div class="frame-58 d-flex">
        <div class="election-2024-2025-en-cours-jusqu-au-15-03-2025">
          <span>Election <span class="fw-bold">2024-2025 </span>
            @if($dateFinVote)
            - En cours jusqu’au<span class="fw-bold">
              {{ \Carbon\Carbon::parse($dateFinVote)->format('d/m/Y') }}
              @else
              <p>Aucun vote en cours pour votre UFR.</p>
              @endif
            </span></span>
        </div>
      </div>
    </div>
  </div>


  <!-- Message d'alerte -->
  <div id="message" class=" alert" role="alert">
    @if(session('success'))
    <div class="alert alert-success  container text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger  container text-center">
      <span class="fw-bold">ATTENTION ! :</span> {{ session('error') }}
    </div>
    @endif
  </div>

  <!-- le liste a voter  -->

  <article class="voting-card-wrapper d-flex justify-content-center align-items-center py-5">
    <div class="voting-card container p-4 shadow rounded">
      <div
        class="card-header text-white rounded p-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
        <figure class="logo-container text-center mb-3 mb-md-0">
          <!-- <p class="logo-text fw-bold">Logo Liste</p> -->
          <img src="{{ asset('image/user_image/image-carte.png') }}" alt="Logo" class="list-image img-fluid">
        </figure>
        <div class="title-section text-center text-md-start">
          <h2 class="list-title fw-bold text-uppercase text-center">{{ $liste->name_list }}</h2>
        </div>
        <div class="image-container text-center">
          <img src="{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}" alt="Logo" class="list-image img-fluid">
        </div>
      </div>

      <section class="progress-section" id="resultatVoteSysteme">

      </section>
      <footer class="confirmation-section">
        <div class="button-wrapper">
          <form action="{{ route('systemevote.vote', ['id' => $liste->id_list]) }}" method="POST">
            @csrf
            <input type="hidden" name="vote_id" id="vote_id" value="{{ $voteId }}">
            <!-- Autres champs du formulaire si nécessaire -->
            <button type="submit" class="confirm-button">
              <span class="button-text">CONFIRMER</span>
              <div class="icon-container">
                <img alt="icon" class="check-square" src="{{ asset('image/user_icons/check-square0.svg') }}" />
              </div>
            </button>
          </form>

        </div>
        <p class="warning-text">
          <strong>Attention</strong>:votre vote est definitif et ne poura pas être
          modifié !
        </p>
      </footer>
    </div>
  </article>

  <!-- resutat en direct  -->
  <div>

    <!-- code de test  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      var resultatsUrl = "{{ route('resultats.json') }}";
      var logoVote = "{{ asset('image/user_image/pictogrammers-material-vote-512-10.png') }}";
      var idList = "{{ $liste->id_list }}";
      var imageCarte = "{{ asset('image/user_image/image-carte.png') }}";
    </script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script src="{{ asset('js/systemeVote.js') }}"></script>


    <!-- resutat en direct  -->

    <div class="results-container container-fluid  m-3 p-3 ">
      <h1 class="results-title text-nowrap">Résultat en temps réel</h1>
      <p class="vote-count text-nowrap">Total des votes : <span class="fw-bold" id="totalVotes">0</span> Votes</p>
    </div>

    <!-- list  -->

    <div class="row m-3 p-3 d-flex justify-content-around " id="resultatVote">
      <!-- premier -->
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






  </div>

  <!-- footer  -->


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

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->


</body>

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
          <a href="https://www.ugb.sn" target="_blank" class="text-decoration-none">www.ugb.sn</a><br>
          <a href="https://portail.ugbnumerique.sn" target="_blank" class="text-decoration-none">portail.ugbnumerique.sn</a>
        </p>
      </div>
    </div>

  </div>
</footer>

</html>