<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UGB Vote - Connexion</title>

    <!-- Liens pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Lien vers le fichier CSS externe -->
    <link rel="stylesheet" href="{{ asset('css/styles-login.css') }}?v={{ time() }}">
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclure le fichier JS externe -->
    <script src="{{ asset('js/login.js') }}"></script>
</head>
<body class="bg-light">
    <header class="header">
        <div class="container">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo UGB" class="logo-rounded">
            </div>
        </div>
    </header>

    <div class="containere">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center position-relative">
                <img src="{{ asset('images/nav-bar.png') }}" alt="Navigation" class="nav-bar-img">
                <p class="navbar-text">Élection du représentant des étudiants</p>
            </div>
        </div>
    </div>

    <!-- Section principale avec toute la largeur disponible -->
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card full-width-card shadow-sm p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('images/vote.png') }}" alt="Vote" class="img-fluid my-3">
                            <p class="fw-bold text-brown">Chaque vote <span class="text-primary">compte</span>. Mobilisons-nous !</p>
                        </div>
                        <div class="col-md-8">
                            <div class="card p-4 border border-dark rounded-3 shadow">
                                <h3 class="text-center text-brown">Connectez-Vous !</h3>

                                <!-- Message d'alerte -->
                                <div id="message" class="d-none alert" role="alert"></div>

                                <form method="POST" action="{{ route('login') }}" class="mt-4" id="loginForm">

                                    @csrf
                                    <div class="mb-3 text-center">
                                        <label for="email" class="form-label fw-bold">E-mail</label>
                                        <input type="email" class="form-control w-50" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3 text-center">
                                        <label for="password" class="form-label fw-bold">Mot de passe</label>
                                        <input type="password" class="form-control w-50" id="password" name="password" required>
                                    </div>
                                    <div class="d-flex justify-content-center mb-3 pe-3">
                                        <a href="{{ route('password.request') }}" class="text-decoration-none">Mot de passe oublié ?</a>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-brown">Connexion</button>
                                    </div>
                                </form>
                                <p class="mt-3 text-center">
                                    Vous n’avez pas de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="social-icons">
            <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
            <a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
            <a href="https://www.youtube.com"><i class="fab fa-youtube"></i></a>
        </div>
        <div class="footer-text">
            <p>© 2025 UGBVote</p>
        </div>
        <div class="footer-links">
            <p><a href="https://www.ugb.sn">www.ugb.sn</a></p>
            <p><a href="https://portail.ugbnumerique.sn">portail.ugbnumerique.sn</a></p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   
</body>
</html>
