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
  <link rel="stylesheet" href="{{ asset('css/styles-login.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('bootstrap/css/inscription.css') }}"> -->



  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <header class="">
    <div class="header-principal w-100 ">
      <nav class="navbar navbar-expand-lg ">
        <!-- Logo -->
        <div class="frugb-vote me-auto">
          <a href="{{ url('/') }}">
            <img alt="img" class="ugb-vote-1" src="{{ asset('image/user_image/logoUBGvote.png') }}" />
          </a>
        </div>

        <!-- Bouton toggle pour les petits écrans -->


        <!-- Liens et pseudo -->
        <div class="liens-speudo collapse navbar-collapse justify-content-end " id="navbarNav">
          <ul class="navbar-nav  liens  d-flex justify-content-center">
            <li class="nav-item">

            </li>
            <li class="nav-item">

            </li>
          </ul>

          <!-- Pseudo à droite -->
          <div class="pseudo me-5 justify-content-end">
            <div class="frame-36">

            </div>
            <div class="frame-93 ms-3">
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

<body>

  <div class="container ">
    <div class="container mx-auto my-auto h-100">
      <div class="row justify-content-center align-items-center pt-5 h-100">

        <!-- Image qui disparaît sur petits écrans -->
        <div class="image-form col-md-6 d-none d-md-block  h-100">
          <img src="{{ asset('image/user_image/vote.png') }}" alt="Vote" class="img-fluid my-3 h-100 w-100 object-fit-cover">
        </div>

        <!-- Formulaire -->
        <div class="col-12 col-md-6 mx-auto my-auto h-100 d-flex flex-column">
          <div class="card  border-alert rounded shadow h-100">
            <h3 class="text-center text-brown voter-pour-votre-repr-sentant">Connectez-Vous !</h3>

            <!-- Message d'alerte -->
            <div id="message" class="d-none alert" role="alert">
              @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
              @endif
              @if($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="mt-4 d-flex flex-column h-100 p-3 m-3 " id="loginForm">
              @csrf


              <div class="col">
                <div class="mb-3 row ">
                  <label for="email" class="form-label fw-bold">E-mail</label>
                  <input type="email" class="form-control w-100 w-md-50 mx-auto" id="mail" name="mail" placeholder="etudiant@ugb.edu.sn" required>
                </div>

                <div class="mb-3 row">
                  <label for="password" class="form-label fw-bold">Mot de passe</label>
                  <input type="password" class="form-control w-100 w-md-50 mx-auto" id="mdp" name="mdp" placeholder="mot de passe" required>
                </div>

                <div class="d-flex justify-content-center mb-3">
                  <a href="#" class="text-decoration-none">Mot de passe oublié ?</a>
                </div>

              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="confirm-button">
                  <span class="button-text">CONNECTER</span>
                  <div class="icon-container">
                    <img alt="icon" class="check-square" src="{{ asset('image/user_icons/check-square0.svg') }}" />
                  </div>
                </button>
              </div>
            </form>

            <p class="mt-3 text-center">
              Vous n’avez pas de compte ? <a href="{{ route('inscription') }}" class="inscrivez-vous text-decoration-none">Inscrivez-vous</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>




  <!-- <script src="{{ asset('js/app.js') }}"></script> -->
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