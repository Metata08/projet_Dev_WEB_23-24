<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Tienne&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/inscription.css') }}">

    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('jquery/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('jquery/form-validation.js') }}"></script>

    <title>Vote UGB - Inscription</title>
</head>
<body>
    <header class="container-fluid">
        <div class="logo">
            <a href="{{url('/')}}"><img src="images/logo.png" alt="Logo de l'Université Gaston Berger" loading="lazy"></a>
        </div>
    </header>
    <div class="header-container">
        <img src="images/header.jpg" alt="Étudiants de l'UGB" loading="lazy">
        <h1 class="page-title">Élection du représentant des étudiants</h1>
    </div>
    <main class="row">
        <div class="col-md-4 col-12 urne">
            <img src="images/urne.png" alt="" srcset="">
        </div>
        <div class="col-md-8 col-12 conteneur-form">
            <div id="alert"></div>
            <h1 class="text">Inscrivez-Vous !</h1>
            <form action="{{route('ajouterEtudiants')}}" id="inscriptionForm" method="post" novalidate name="formulaire">
                @csrf
                <div class="row">
                    <div class="form-group mb-3 position-relative col">
                        <label for="prenom" class="form-label position-absolute bg-white px-2">
                            Entrez votre prénom
                        </label>
                        <input type="text" name="prenom" class="form-control" id="prenom" value="{{ old('prenom') }}" required>
                        @error('prenom') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group mb-3 position-relative col">
                        <label for="nom" class="form-label position-absolute bg-white px-2">
                            Entrez votre nom
                        </label>
                        <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required>
                        @error('nom') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group mb-3 position-relative">
                    <label for="email" class="form-label position-absolute bg-white px-2">
                        Entrez votre e-mail
                    </label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <span class="error">{{ $message }}</span> @enderror

                </div>
                <div class="form-group mb-3 position-relative">
                    <label for="ufr" class="form-label position-absolute bg-white px-2">
                        Sélectionner votre ufr
                    </label>
                    <select name="ufr" id="ufr" class="form-control">
                        <option value="sciences">Sciences et Technologies</option>
                        <option value="lettres">Lettres et Sciences Humaines</option>
                        <option value="droit">Droit</option>
                        <option value="economie">Économie et Gestion</option>   
                    </select>
                </div>
                <div class="form-group mb-3 position-relative">
                    <label for="password" class="form-label position-absolute bg-white px-2">
                        Entrer votre password
                    </label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mb-3 position-relative">
                    <label for="confpassword" class="form-label position-absolute bg-white px-2">
                        Confirmer votre password
                    </label>
                    <input type="password" name="password_confirmation" id="confpassword" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn text-white valider">Valider</button>
                    </div>
                    <div class="col">
                        <button type="reset" class="btn text-white annuler bg-danger">Annuler</button>
                    </div>
                </div>
                <div class="mt-3">
                    <p style="font-family:Inter; font-weigth: bold;">Avez-vous déjà un compte? <a href="#">Connectez-vous</a></p>
                </div>
            </form>
        </div>
    </main>
    <footer class="row">
        <div class="col col-md-4">reseaux</div>
        <div class="col col-md-4">@ 2025 UGBVote</div>
        <div class="col col-md-4">Liens utiles</div>
    </footer>
    <script>
        
    </script>
</body>
</html>