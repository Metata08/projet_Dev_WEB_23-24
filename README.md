<p align="center">
  <img src="image/ugb%20vote.jpg" alt="UGB Vote" width="420">
</p>

<h1 align="center">UGB Vote</h1>

<p align="center">
  <b>Plateforme web d'organisation et de gestion de l'élection du représentant des étudiants</b><br>
  Université Gaston Berger (UGB) · Master 1 GDIL · UE Programmation Web Avancée · 2024-2025
</p>

<p align="center">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-%E2%89%A5%208.2-777BB4?logo=php&logoColor=white">
  <img alt="Design system" src="https://img.shields.io/badge/Design%20system-maison%20(0%20CDN)-ab775b">
  <img alt="CSP" src="https://img.shields.io/badge/CSP-stricte-522504">
  <img alt="Tests" src="https://img.shields.io/badge/tests-24%20pass%C3%A9s-2f7a4f">
</p>

---

## ✨ Refonte 2026 — branche `mg4`

> Toute la plateforme a été redessinée et sécurisée, **en conservant le nom du site et la palette d'origine**
> (brun `#522504` · caramel `#ab775b` · sable `#f0e0d0`). Les captures ci-dessous sont prises sur l'application
> réelle (jeu de données de démonstration), sur ordinateur, tablette et téléphone.

![Accueil — ordinateur](image_pages/v2/pc-accueil-hero.jpg)

### Ce qui change

| | Avant | Maintenant |
|---|---|---|
| **Interface** | Bootstrap + gabarit AdminLTE, pages indépendantes | Design system maison (`public/assets/app.css`), gabarits Blade communs, thème **clair / sombre** |
| **Animations** | Carrousel d'images | Fond « aurora » animé, particules interactives, urne animée, apparitions au défilement, compteurs, cartes 3D, transitions entre pages, confettis après le vote |
| **Responsive** | Partiel | Mise en page fluide (mobile, tablette, PC), menu mobile, tableaux transformés en cartes, zéro défilement horizontal |
| **Temps réel** | Graphique rechargé en AJAX | Classement, anneau de répartition et participation actualisés toutes les 5 s, avec réordonnancement animé |
| **Dépendances front** | ≈ 9 400 fichiers tiers dans `public/` (jQuery, CKEditor, Flot…) et plusieurs CDN | **Aucun CDN, aucune bibliothèque** : polices, icônes et scripts auto-hébergés (≈ 1 Mo) |
| **Administration** | Accessible **sans connexion**, mot de passe **en clair** | Garde `auth:admin`, mot de passe haché (bcrypt), vraie déconnexion |
| **Vote** | Double vote possible (une fois par liste), `vote_id` fourni par le navigateur, choix de chaque étudiant lisible en base | **Un vote par étudiant et par scrutin** garanti par un index unique ; scrutin déduit côté serveur ; **bulletin anonyme** avec reçu vérifiable |
| **Campagne** | Un nom de liste et un texte | Page de campagne (slogan, logo, propositions par thème, bilan, équipe), espace candidat, comparateur de programmes |

### Sécurité et fiabilité

- **Espace administrateur protégé** : toutes les routes `/admin/*` exigent une session du garde `admin` ; une migration hache automatiquement les mots de passe administrateur qui étaient stockés en clair.
- **Vote infalsifiable** : index unique `(etudiant_id, vote_id)`, liste obligatoirement dans l'UFR de l'étudiant, période d'ouverture du scrutin contrôlée côté serveur, confirmation explicite obligatoire.
- **Cloisonnement par UFR** : listes, programmes et résultats d'une autre UFR renvoient une erreur 404.
- **Anti force brute** : 5 tentatives de connexion par minute (étudiant et administrateur), limites sur l'inscription et le vote.
- **Inscription renforcée** : code étudiant officiel obligatoire et à usage unique, mot de passe ≥ 8 caractères avec lettres et chiffres, e-mail normalisé.
- **En-têtes HTTP** : Content-Security-Policy stricte (`script-src 'self'`, `style-src 'self'`, aucun script ni style « inline »), `X-Frame-Options: DENY`, `nosniff`, `Referrer-Policy`, `Permissions-Policy`, HSTS en HTTPS.
- **Sessions** : identifiant régénéré à la connexion, session invalidée à la déconnexion, chiffrement activé (`SESSION_ENCRYPT=true`), jeton CSRF sur tous les formulaires.
- **Surface d'attaque réduite** : suppression des anciens scripts PHP exécutables dans `public/includes/` et des bibliothèques tierces obsolètes.
- **Secret du vote** : l'émargement (qui a voté) et le bulletin (pour qui) sont deux tables sans lien ; un bulletin ne porte ni étudiant, ni date, ni numéro d'ordre.
- **24 tests automatisés** (`php artisan test`) couvrent ces règles : double vote, vote hors UFR, vote hors période, anonymat du bulletin, reçu, résultats masqués, espace candidat, envoi de fichiers, accès administrateur, inscription, mot de passe oublié, limitation de débit, en-têtes de sécurité.

### Nouvelles fonctionnalités

**Confiance dans le scrutin**

- **Vote anonyme et reçu vérifiable** : après son vote, l'étudiant reçoit un code (`UGB-XXXX-XXXX-XXXX`) affiché une seule fois. La page « Vérifier mon reçu » confirme que le bulletin est dans l'urne, **sans jamais indiquer la liste choisie** (un reçu ne peut donc pas servir à prouver son vote à un tiers).
- **Résultats en direct ou à la clôture** : l'administrateur choisit, UFR par UFR. En mode « à la clôture », seule la participation est visible pendant le vote.
- **Mot de passe oublié** : lien à usage unique envoyé par e-mail, valable 60 minutes.
- **Import des codes étudiants** : fichier CSV ou texte, ou ajout à l'unité, depuis l'administration.

| Reçu de vote | Vérification du reçu |
|---|---|
| ![Reçu](image_pages/v2/pc-recu.jpg) | ![Reçu vérifié](image_pages/v2/pc-recu-verifie.jpg) |

| Résultats masqués jusqu'à la clôture | Mot de passe oublié |
|---|---|
| ![Résultats masqués](image_pages/v2/pc-resultats-masques.jpg) | ![Mot de passe oublié](image_pages/v2/pc-mot-de-passe-oublie.jpg) |

**Campagne**

- **Page de campagne** par liste : logo, slogan, présentation, propositions classées par thème, **bilan et réalisations** de l'équipe, membres avec leur rôle.
- **Espace candidat** : la tête de liste rédige elle-même sa page (menu « Ma liste »). Toute modification repasse **en attente de validation** : les autres étudiants ne la voient qu'une fois validée par l'administrateur.
- **Comparateur** : les propositions de toutes les listes de l'UFR, côte à côte, thème par thème.

![Page de campagne](image_pages/v2/pc-campagne.jpg)

| Espace candidat | Comparateur de programmes |
|---|---|
| ![Espace candidat](image_pages/v2/pc-espace-candidat.jpg) | ![Comparateur](image_pages/v2/pc-comparateur.jpg) |

**Suivi et administration**

- **E-mails** : confirmation de participation (sans le choix ni le reçu), rappel le dernier jour aux seuls non-votants, annonce des résultats le lendemain de la clôture.
- **Gestion d'une liste** : validation de la page de campagne, ajout et retrait de membres, désignation de la tête de liste.
- **Procès-verbal** de dépouillement par UFR, imprimable ou enregistrable en PDF depuis le navigateur.
- **Journal** des actions d'administration (connexion, suppressions, imports, modifications de scrutin…).

| Gestion d'une liste | Codes étudiants |
|---|---|
| ![Gestion d'une liste](image_pages/v2/pc-admin-liste.jpg) | ![Codes](image_pages/v2/pc-admin-codes.jpg) |

| Procès-verbal | Journal |
|---|---|
| ![Procès-verbal](image_pages/v2/pc-admin-proces-verbal.jpg) | ![Journal](image_pages/v2/pc-admin-journal.jpg) |

### Espace étudiant

| Connexion | Inscription (validation en direct) |
|---|---|
| ![Connexion](image_pages/v2/pc-connexion.jpg) | ![Inscription](image_pages/v2/pc-inscription.jpg) |

| Listes candidates et compte à rebours | Page de campagne d'une liste |
|---|---|
| ![Élections](image_pages/v2/pc-election.jpg) | ![Programme](image_pages/v2/pc-programme.jpg) |

| Bulletin de vote | « A voté ! » (confettis) |
|---|---|
| ![Vote](image_pages/v2/pc-vote.jpg) | ![A voté](image_pages/v2/pc-a-vote.jpg) |

**Résultats en direct**

![Résultats](image_pages/v2/pc-resultats.jpg)

### Thème sombre

| Accueil | Résultats |
|---|---|
| ![Accueil sombre](image_pages/v2/pc-accueil-sombre.jpg) | ![Résultats sombre](image_pages/v2/pc-resultats-sombre.jpg) |

### Espace administrateur

![Tableau de bord](image_pages/v2/pc-admin-tableau-de-bord.jpg)

| Électeurs | Listes |
|---|---|
| ![Électeurs](image_pages/v2/pc-admin-electeurs.jpg) | ![Listes](image_pages/v2/pc-admin-listes.jpg) |

| Ajout d'une liste | Scrutins (périodes de vote par UFR) |
|---|---|
| ![Ajout](image_pages/v2/pc-admin-ajout-liste.jpg) | ![Scrutins](image_pages/v2/pc-admin-scrutins.jpg) |

### Tablette

<p align="center">
  <img src="image_pages/v2/tablette-accueil.jpg" width="32%" alt="Accueil — tablette">
  <img src="image_pages/v2/tablette-election.jpg" width="32%" alt="Élections — tablette">
  <img src="image_pages/v2/tablette-admin-tableau-de-bord.jpg" width="32%" alt="Tableau de bord — tablette">
</p>

### Téléphone

<p align="center">
  <img src="image_pages/v2/mobile-accueil.jpg" width="24%" alt="Accueil — mobile">
  <img src="image_pages/v2/mobile-menu.jpg" width="24%" alt="Menu — mobile">
  <img src="image_pages/v2/mobile-election.jpg" width="24%" alt="Élections — mobile">
  <img src="image_pages/v2/mobile-vote.jpg" width="24%" alt="Vote — mobile">
</p>
<p align="center">
  <img src="image_pages/v2/mobile-resultats.jpg" width="24%" alt="Résultats — mobile">
  <img src="image_pages/v2/mobile-inscription.jpg" width="24%" alt="Inscription — mobile">
  <img src="image_pages/v2/mobile-admin-menu.jpg" width="24%" alt="Menu administrateur — mobile">
  <img src="image_pages/v2/mobile-campagne.jpg" width="24%" alt="Page de campagne — mobile">
</p>

Toutes les captures (69) sont dans [`image_pages/v2/`](image_pages/v2). Les sections suivantes reprennent la présentation
d'origine du projet ; les captures du [manuel d'utilisation](#8-manuel-dutilisation) montrent l'ancienne interface.

---

## Sommaire

1. [Présentation](#1-présentation)
2. [Reformulation des besoins](#2-reformulation-des-besoins)
3. [Analyse fonctionnelle](#3-analyse-fonctionnelle)
4. [Fonctionnalités réalisées](#4-fonctionnalités-réalisées)
5. [Architecture technique](#5-architecture-technique)
6. [Modèle de données](#6-modèle-de-données)
7. [Manuel d'installation](#7-manuel-dinstallation)
8. [Manuel d'utilisation](#8-manuel-dutilisation)
9. [Planification du projet](#9-planification-du-projet)
10. [Équipe](#10-équipe)
11. [Structure du dépôt](#11-structure-du-dépôt)
12. [Limites connues et pistes d'amélioration](#12-limites-connues-et-pistes-damélioration)

📄 Documents de référence présents dans le dépôt :

| Document | Contenu |
|---|---|
| [`M1 GDIL_Projet_Complement&Frameworks.pdf`](M1%20GDIL_Projet_Complement%26Frameworks.pdf) | Sujet officiel du projet |
| [`rapportPROJET-vis.pdf`](rapportPROJET-vis.pdf) | Rapport de projet (besoins, analyse, maquettes, Gantt) |
| [`manuel d'utilisation.pdf`](manuel%20d'utilisation.pdf) | Manuel d'utilisation illustré (PC et mobile) |
| [`2025-04-02_ugbvote.docx`](2025-04-02_ugbvote.docx) | Dictionnaire de données de la base `ugbvote` |
| [`données_test.txt`](donn%C3%A9es_test.txt) | Comptes de test (étudiant et administrateur) |

---

## 1. Présentation

**UGB Vote** est une plateforme web **responsive** permettant d'organiser et de gérer en ligne l'élection du
représentant des étudiants. Elle garantit **transparence, accessibilité et fiabilité** du processus électoral grâce à :

- un **vote électronique sécurisé** (un seul vote par étudiant) ;
- une **présentation des listes candidates** et de leur programme ;
- un **suivi des résultats en temps réel**, mis à jour automatiquement (AJAX) ;
- un **espace administrateur** de pilotage de l'élection.

> *« Votre avenir, votre voix. Élisez des représentants engagés pour vous ! »*

![Page d'accueil](image_pages/pc/accueil.png)

---

## 2. Reformulation des besoins

L'objectif est de concevoir une plateforme d'élection en ligne pour élire le représentant des étudiants.
**Seuls les étudiants appartenant à une UFR peuvent s'inscrire et voter, et uniquement pour une liste de leur UFR.**

La plateforme doit :

- faciliter l'organisation des élections de manière transparente et sécurisée ;
- assurer un vote fiable, en empêchant toute fraude ou double vote ;
- offrir une interface intuitive et accessible ;
- afficher les résultats en temps réel, avec mise à jour automatique ;
- n'autoriser l'inscription qu'aux étudiants **validés par l'université** (code étudiant officiel) ;
- limiter chaque étudiant à **un seul vote** ;
- être **responsive** (mobile, tablette et ordinateur).

---

## 3. Analyse fonctionnelle

### Besoins fonctionnels

| Module | Description |
|---|---|
| **Gestion des étudiants** | Inscription possible seulement si l'étudiant est reconnu dans la base de l'université (code officiel) · Vérification de l'appartenance à une UFR · Connexion sécurisée |
| **Consultation des candidats** | L'étudiant ne voit que les listes de son UFR · Consultation du programme détaillé et des membres de chaque liste |
| **Vote électronique sécurisé** | Un seul vote par étudiant, uniquement pour une liste de son UFR · Confirmation avant validation · Vérification anti double vote avant enregistrement |
| **Résultats en temps réel** | Mise à jour automatique après chaque vote · Affichage du nombre de voix et du pourcentage par liste |
| **Gestion administrateur** | Ajout / suppression de candidats (listes) · Suivi des votes · Gestion des électeurs |

### Besoins non fonctionnels

| Critère | Exigence |
|---|---|
| **Sécurité** | Authentification sécurisée (mots de passe hachés, sessions régénérées, jetons CSRF) · Validation stricte des données côté client (jQuery Validate) et serveur (Laravel) |
| **Performance** | Requêtes SQL optimisées (agrégation des votes) · Rafraîchissement des résultats sans rechargement de page (AJAX) |
| **Expérience utilisateur** | Interface moderne (Bootstrap, Flexbox) · Compatible mobile et tablette |

---

## 4. Fonctionnalités réalisées

### Côté étudiant
- ✅ **Inscription** avec contrôle du code étudiant officiel, de l'UFR, de l'unicité de l'e-mail et de la confirmation du mot de passe.
- ✅ **Validation en direct** des formulaires (messages d'erreur sous chaque champ, jauge de robustesse du mot de passe).
- ✅ **Connexion / déconnexion** avec messages de confirmation.
- ✅ **Liste des élections** : affichage des listes candidates de l'UFR de l'étudiant connecté.
- ✅ **Détail d'une liste** : titre du programme, programme complet et membres de la liste.
- ✅ **Vote** avec fenêtre de **confirmation** et blocage du **double vote** (message d'erreur explicite).
- ✅ **Résultats en temps réel** : barres de progression (voix et pourcentage), anneau de répartition et participation, rafraîchis toutes les 5 s (`GET /resultats/json`).

### Côté administrateur
- ✅ **Connexion administrateur** dédiée (`/admin`, garde d'authentification séparée).
- ✅ **Tableau de bord** : nombre de postes (UFR), de candidats, d'électeurs inscrits et de votants + décompte des votes par UFR et participation, actualisés en direct.
- ✅ **Gestion des listes candidates** (ajout, suppression), **des électeurs** (recherche, suppression) et **des scrutins** (dates d'ouverture et de clôture par UFR).

![Tableau de bord administrateur](image_pages/dashbord_UGBvote.png)

---

## 5. Architecture technique

| Couche | Technologies |
|---|---|
| **Back-end** | Laravel 12 (PHP ≥ 8.2), Eloquent ORM, Blade, authentification multi-gardes (`web` → étudiants, `admin` → administrateurs) |
| **Front-end** | HTML5 / CSS3, **Bootstrap**, **Flexbox**, **jQuery**, **AJAX**, jQuery Validate, Font Awesome 6 |
| **Administration** | Thème AdminLTE, Chart.js |
| **Base de données** | MySQL (base `ugbvote`) — SQLite possible pour les tests |
| **Outils** | Composer, npm / Vite, Figma (maquettes), GanttProject (planification), Git / GitHub |

### Principales routes

| Méthode | URL | Rôle |
|---|---|---|
| GET | `/` , `/ugbvote` | Page d'accueil |
| GET / POST | `/inscription` | Formulaire et traitement de l'inscription |
| GET / POST | `/login` | Formulaire et traitement de la connexion étudiant |
| POST | `/logout` | Déconnexion |
| GET | `/election` | Listes candidates de l'UFR (authentifié) |
| GET | `/detailListe/{id}` | Programme et membres d'une liste |
| GET / POST | `/systemevote/{id}` | Page de vote et enregistrement du vote |
| GET | `/resultat` | Page des résultats |
| GET | `/resultats/json` | API JSON des résultats (consommée en AJAX) |
| GET / POST | `/recu` | Vérification d'un reçu de vote |
| GET | `/comparer` | Comparateur de programmes de l'UFR |
| GET / PUT / POST / DELETE | `/ma-liste`, `/ma-liste/propositions`, `/ma-liste/realisations` | Espace candidat (tête de liste) |
| GET / POST | `/mot-de-passe-oublie`, `/reinitialiser/{token}` | Réinitialisation du mot de passe |
| GET / POST | `/admin`, `/admin/login` | Connexion administrateur |
| POST | `/admin/logout` | Déconnexion administrateur |
| GET | `/admin/tableau-de-bord`, `/admin/stats.json` | Tableau de bord et son flux temps réel |
| GET / DELETE | `/admin/electeurs`, `/admin/electeurs/{id}` | Consultation et suppression des électeurs |
| GET / POST / DELETE | `/admin/listes`, `/admin/listes/{id}` | Consultation, ajout et suppression des listes |
| GET / PUT | `/admin/scrutins`, `/admin/scrutins/{id}` | Périodes de vote et visibilité des résultats par UFR |
| GET | `/admin/scrutins/{id}/proces-verbal` | Procès-verbal imprimable |
| GET / POST / DELETE | `/admin/listes/{id}`, `…/valider`, `…/membres` | Campagne et membres d'une liste |
| GET / POST / DELETE | `/admin/codes` | Codes étudiants officiels (ajout, import CSV, suppression) |
| GET | `/admin/journal` | Journal des actions d'administration |

Les routes de l'espace étudiant exigent le garde `web`, celles de `/admin/*` le garde `admin`.

### Organisation du code Laravel

```
voteUGB/
├── app/Http/Controllers/
│   ├── login_controller.php        # accueil, connexion, déconnexion étudiant
│   ├── inscription_controller.php  # inscription + validation des données
│   ├── user_controller.php         # élections, détail d'une liste, vote, résultats
│   ├── CampagneController.php      # espace candidat, comparateur, logo
│   ├── MotDePasseController.php    # mot de passe oublié
│   ├── AdminController.php         # connexion admin, tableau de bord, gestion
│   └── AdminGestionController.php  # campagne d'une liste, codes, procès-verbal, journal
├── app/Notifications/              # e-mails (réinitialisation, confirmation, rappel, résultats)
├── app/Http/Middleware/SecurityHeaders.php  # CSP et en-têtes de sécurité
├── app/Support/Depouillement.php   # calcul des résultats d'une UFR
├── app/Models/                     # Etudiant, EtudiantOfficiel, UFR, Listes,
│                                   # MembresListe, Votes, VoteEtudiant, Admin
├── database/migrations/            # schéma de la base
├── database/seeders/UgbvoteSeeder.php  # jeu de données de démonstration
├── resources/views/
│   ├── layouts/                    # gabarits communs (app, admin)
│   ├── components/icon.blade.php   # jeu d'icônes SVG auto-hébergé
│   ├── errors/                     # pages 403, 404, 419, 429, 500, 503
│   ├── ugbvote.blade.php           # accueil
│   ├── user/                       # login, inscription, election, detailListe,
│   │                               # systemevote, resultat
│   └── admin/                      # login, home (dashboard), candidates, postes, electeurs
├── public/assets/                  # app.css (design system), app.js (animations, temps réel), theme.js
├── public/fonts/                   # polices Sora et Inter auto-hébergées
├── tests/Feature/                  # règles du scrutin, anonymat, campagne, administration
└── routes/web.php
```

---

## 6. Modèle de données

![Diagramme de classes](model/Diagramme%20de%20classes.png)

| Table | Rôle |
|---|---|
| `etudiant_officiels` | Codes étudiants reconnus par l'université (condition d'inscription) |
| `u_f_r_s` | UFR (ex. SAT, SJP), chacune rattachée à un scrutin |
| `etudiants` | Étudiants inscrits (nom, prénom, code, e-mail, UFR, mot de passe haché) |
| `votes` | Scrutins (date de début / date de fin) |
| `listes` | Listes candidates : nom, titre et programme, UFR |
| `membres_listes` | Membres de chaque liste |
| `vote_etudiants` | Bulletins : étudiant, scrutin, liste choisie, date du vote |
| `admins` | Comptes administrateurs |

Le dictionnaire de données complet (colonnes, types, clés) se trouve dans [`2025-04-02_ugbvote.docx`](2025-04-02_ugbvote.docx).

---

## 7. Manuel d'installation

### Prérequis
- PHP ≥ 8.2 avec les extensions `mbstring`, `openssl`, `xml` et `pdo_mysql` (ou `pdo_sqlite`)
- Composer 2
- MySQL / MariaDB (XAMPP, WAMP, Laragon… conviennent) ou SQLite
- Node.js n'est **pas** nécessaire : l'interface est servie directement depuis `public/assets/`

### Étapes

1. **Cloner le dépôt et choisir la branche**

   ```bash
   git clone -b mg4 https://github.com/Metata08/projet_Dev_WEB_23-24.git
   ```

   ```bash
   cd projet_Dev_WEB_23-24/voteUGB
   ```

2. **Installer les dépendances PHP**

   ```bash
   composer install
   ```

3. **Configurer l'environnement**

   ```bash
   cp .env.example .env
   ```

   ```bash
   php artisan key:generate
   ```

   Adapter au besoin les variables `DB_*` du fichier `.env` (par défaut : base MySQL `ugbvote`, utilisateur `root`).
   En production, mettre `APP_ENV=production`, `APP_DEBUG=false` et `SESSION_SECURE_COOKIE=true`.

4. **Créer la base `ugbvote`** dans MySQL, puis lancer les migrations et le jeu de données :

   ```bash
   php artisan migrate --seed
   ```

   Le jeu de données ouvre le scrutin de l'UFR SAT (du J-3 au J+12) : la démonstration est toujours « en cours ».

5. **Lancer l'application**

   ```bash
   php artisan serve
   ```

   L'application est accessible sur <http://localhost:8000>, l'espace administrateur sur <http://localhost:8000/admin>.

6. **E-mails** (facultatif en local) — par défaut `MAIL_MAILER=log` : les messages (lien de réinitialisation, confirmation de vote, rappels) sont écrits dans `storage/logs/laravel.log`. Pour un envoi réel, renseigner les variables `MAIL_*` du `.env` (SMTP de l'université, par exemple).

   Les rappels de vote et l'annonce des résultats partent une fois par jour. Sur le serveur, ajouter cette ligne à la crontab :

   ```bash
   * * * * * cd /chemin/vers/voteUGB && php artisan schedule:run >> /dev/null 2>&1
   ```

   ou lancer l'envoi à la main :

   ```bash
   php artisan ugbvote:notifier
   ```

7. **Lancer les tests** (base SQLite en mémoire, sans toucher à vos données)

   ```bash
   php artisan test
   ```

> **Mise à jour d'une installation existante** : `php artisan migrate` suffit. La migration
> `2026_11_11_000000_securise_votes_et_admins` hache les mots de passe administrateur encore en clair et, si un
> étudiant avait plusieurs bulletins pour un même scrutin, ne conserve que le premier avant d'ajouter l'index unique.
> La migration `2026_11_12_000000_campagne_et_secret_du_vote` convertit ensuite les votes existants en émargements et en
> bulletins anonymes, puis **supprime définitivement** l'ancienne table nominative `vote_etudiants` : faites une sauvegarde
> de la base avant si vous souhaitez conserver l'historique nominatif.

### Comptes de test

| Rôle | E-mail | Mot de passe |
|---|---|---|
| Étudiant (a déjà voté) | `ameth@gmail.com` | `ameth31` |
| Tête de liste (espace candidat « Ma liste ») | `anta@gmail.com` | `anta31` |
| Administrateur | `admin@gmail.com` | `admin123` |

Pour tester l'inscription puis le vote, utiliser l'un des codes étudiants libres : `p31 3001`, `p31 3002` ou `p31 3003` (UFR **SAT**, dont le scrutin est ouvert).

---

## 8. Manuel d'utilisation

Résumé du [manuel d'utilisation illustré (PDF)](manuel%20d'utilisation.pdf). Le parcours est identique sur ordinateur et sur mobile.

### 8.1 Accueil
La page d'accueil présente les 4 étapes du processus : **1. Connexion → 2. Choisir une liste → 3. Voter → 4. Résultats**.
Le bouton **« Se connecter »** (en haut à droite, ou dans le menu ☰ sur mobile) mène à la page de connexion.

| PC | Mobile |
|---|---|
| ![Accueil PC](image_pages/pc/accueil.png) | <img src="image_pages/mobile/accueil_mb.png" width="220"> |

### 8.2 Inscription
1. Depuis la page de connexion, cliquer sur **« Inscrivez-vous »**.
2. Remplir le formulaire : prénom, nom, **code étudiant**, e-mail, **UFR**, mot de passe et confirmation.
3. Si des champs sont vides ou incorrects, un message d'erreur rouge s'affiche sous chacun d'eux.
4. Une fois les champs corrects, cliquer sur **« Valider »** : l'étudiant est redirigé vers la connexion avec le message *« Inscription réussie ! »*.

| Formulaire | Champs incorrects | Champs corrects |
|---|---|---|
| ![](image_pages/pc/inscription.png) | ![](image_pages/pc/incription_validation_jQuery.png) | ![](image_pages/pc/inscription_input.png) |

### 8.3 Connexion
Saisir l'e-mail et le mot de passe puis cliquer sur **« Connecter »**. En cas d'erreur, le message *« E-mail ou mot de passe incorrect »* s'affiche.

| Connexion | Après inscription |
|---|---|
| ![](image_pages/pc/connexion.png) | ![](image_pages/pc/connexio_after_inscription.png) |

### 8.4 Choisir une liste et consulter son programme
Une fois connecté, l'étudiant voit les listes candidates **de son UFR**. Le bouton **« Voir programme »** affiche le titre, le programme complet et les membres de la liste.

| Listes de l'UFR | Détail d'une liste |
|---|---|
| ![](image_pages/pc/election_after_connexion.png) | ![](image_pages/pc/detail_liste.png) |

### 8.5 Voter
1. Cliquer sur **« Voter »** sur la liste choisie.
2. Cliquer sur **« Confirmer »** puis valider dans la fenêtre de confirmation (le vote est définitif).
3. Un message confirme l'enregistrement du vote. Toute nouvelle tentative est refusée : *« Vous avez déjà voté pour ce vote en cours »*.

| Page de vote | Confirmation | Double vote refusé |
|---|---|---|
| ![](image_pages/pc/sys_Vote.png) | ![](image_pages/pc/confirm_vote.png) | ![](image_pages/pc/confirm_vote2_Erreur.png) |

### 8.6 Résultats en temps réel
La section **« Résultat en temps réel »** affiche, pour chaque liste, le nombre de voix et le pourcentage obtenus, ainsi que le total des votes. Les valeurs se mettent à jour automatiquement toutes les 5 secondes, sans recharger la page.

<p align="center"><img src="image_pages/pc/resultats.png" width="600"></p>

### 8.7 Déconnexion
L'icône de déconnexion (en haut à droite) ramène à la page de connexion avec le message *« Déconnexion réussie »*.

| Déconnexion | Après déconnexion |
|---|---|
| ![](image_pages/pc/deconnexion.png) | ![](image_pages/pc/connexion_after_deconnexion.png) |

### 8.8 Version mobile

| Connexion | Inscription | Élections | Vote | Résultats |
|---|---|---|---|---|
| <img src="image_pages/mobile/connexion_mb.png" width="150"> | <img src="image_pages/mobile/inscription_mb.png" width="150"> | <img src="image_pages/mobile/election_after_connexion_mb.png" width="150"> | <img src="image_pages/mobile/confim_vote_mb.png" width="150"> | <img src="image_pages/mobile/resultats_mb.png" width="150"> |

### 8.9 Espace administrateur
1. Aller sur `/admin` et se connecter avec un compte administrateur.
2. Le **tableau de bord** affiche les indicateurs clés (postes, candidats, électeurs, votants) et le graphique des votes.
3. Le menu latéral donne accès à la gestion des **candidats**, des **postes** et des **électeurs**.

---

## 9. Planification du projet

Le projet a été planifié avec **GanttProject** (du 9 mars au 1ᵉʳ avril 2025).

| Tâche | Début | Fin | Responsable(s) |
|---|---|---|---|
| Reformulation des besoins | 09/03/25 | 11/03/25 | Mame Anta BATHILY, Mouhamed GUEYE, Daouda FICKOU |
| Analyse fonctionnelle des besoins | 09/03/25 | 11/03/25 | Mame Anta BATHILY, Mouhamed GUEYE, Daouda FICKOU |
| Maquette (Figma) | 10/03/25 | 19/03/25 | Mouhamed GUEYE, Mame Anta BATHILY, Daouda FICKOU |
| Connexion | 21/03/25 | 22/03/25 | Mame Anta BATHILY |
| Candidats | 23/03/25 | 24/03/25 | Mame Anta BATHILY |
| Page d'accueil (Flexbox) | 21/03/25 | 24/03/25 | Daouda FICKOU |
| Page d'inscription (Bootstrap) | 24/03/25 | 28/03/25 | Daouda FICKOU |
| Système de vote | 20/03/25 | 24/03/25 | Mouhamed GUEYE |
| Détail d'une liste | 24/03/25 | 27/03/25 | Mouhamed GUEYE |
| Intégration et débogage | 27/03/25 | 01/04/25 | Mouhamed GUEYE |

### Maquettes (Figma)

| Accueil | Inscription | Connexion |
|---|---|---|
| ![](maquette/Accueil.png) | ![](maquette/Inscription.png) | ![](maquette/Connexion.png) |

| Candidats | Détail candidat | Système de vote |
|---|---|---|
| ![](maquette/Candidats.png) | ![](maquette/D%C3%A9tail%20candidat.png) | ![](maquette/systeme%20de%20vote%20.png) |

---

## 10. Équipe

Projet réalisé en groupe de trois étudiants du **Master 1 GDIL** (Université Gaston Berger de Saint-Louis) :

- **Mame Anta BATHILY**
- **Mouhamed GUEYE**
- **Daouda FICKOU**

Encadrement : **Awa DIATTARA** & **Abdou Khadre GUEYE** — UE Compléments de programmation Web / Frameworks et IDEs Web.

---

## 11. Structure du dépôt

```
.
├── voteUGB/                 # Application Laravel (code source)
├── maquette/                # Maquettes Figma de l'interface
├── model/                   # Diagramme de classes
├── image/                   # Logos, icônes et visuels
├── image_pages/             # Captures d'écran de l'application (pc/ et mobile/)
├── rapportPROJET-vis.pdf    # Rapport de projet
├── manuel d'utilisation.pdf # Manuel d'utilisation
├── 2025-04-02_ugbvote.docx  # Dictionnaire de données
├── données_test.txt         # Comptes de test
└── M1 GDIL_Projet_Complement&Frameworks.pdf  # Sujet
```

---

## 12. Limites connues et pistes d'amélioration

**Traité dans la refonte `mg4` :** protection des routes administrateur et étudiant, vote unique garanti par la base,
contrôle des dates du scrutin, secret du vote avec reçu, mot de passe oublié, import des codes, pages de campagne,
journal d'administration, procès-verbal, tests automatisés.

**Limites à connaître :**
- **Anonymat** : l'application ne conserve aucun lien entre un étudiant et son bulletin. Une personne ayant accès au serveur *pendant* le vote (journaux de requêtes, sauvegardes prises entre deux votes) pourrait toutefois recouper des informations : pour un scrutin à fort enjeu, l'hébergement doit être confié à un tiers de confiance.
- **Suppression en cours de scrutin** : supprimer un électeur ne retire pas son bulletin (il est anonyme) ; supprimer une liste retire ses bulletins mais pas les émargements. Le procès-verbal signale alors l'écart.
- **Réalisations des listes** : elles sont déclaratives ; l'administrateur les relit avant publication mais ne les certifie pas.
- **E-mails** : envoyés au fil de l'eau, sans file d'attente ; au-delà de quelques centaines d'électeurs, configurer une file (`QUEUE_CONNECTION`).

**Pistes d'amélioration :**
- Vérification de l'adresse e-mail à l'inscription.
- Double authentification pour l'espace administrateur.
- Questions des étudiants aux listes, avec modération.
- Notifications SMS / WhatsApp et application installable (PWA).
- Photos des membres et modification d'une liste (nom, UFR) depuis l'administration.

---

<p align="center">© 2025 UGB Vote — Université Gaston Berger de Saint-Louis</p>
