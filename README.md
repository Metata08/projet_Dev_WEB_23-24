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
  <img alt="Bootstrap" src="https://img.shields.io/badge/Bootstrap-UI-7952B3?logo=bootstrap&logoColor=white">
  <img alt="jQuery" src="https://img.shields.io/badge/jQuery-AJAX-0769AD?logo=jquery&logoColor=white">
  <img alt="Chart.js" src="https://img.shields.io/badge/Chart.js-dashboard-FF6384?logo=chartdotjs&logoColor=white">
</p>

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
- ✅ **Validation en direct** des formulaires avec jQuery Validate (messages d'erreur sous chaque champ).
- ✅ **Connexion / déconnexion** avec messages de confirmation.
- ✅ **Liste des élections** : affichage des listes candidates de l'UFR de l'étudiant connecté.
- ✅ **Détail d'une liste** : titre du programme, programme complet et membres de la liste.
- ✅ **Vote** avec fenêtre de **confirmation** et blocage du **double vote** (message d'erreur explicite).
- ✅ **Résultats en temps réel** : barres de progression (voix et pourcentage), rafraîchies toutes les 5 s via AJAX (`GET /resultats/json`).

### Côté administrateur
- ✅ **Connexion administrateur** dédiée (`/admin`, garde d'authentification séparée).
- ✅ **Tableau de bord** : nombre de postes (UFR), de candidats, d'électeurs inscrits et de votants + graphique des votes par UFR (Chart.js).
- ✅ **Gestion des listes candidates** (ajout), **des postes** et **des électeurs** (consultation, suppression).

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
| GET / POST | `/admin`, `/admin/login` | Connexion administrateur |
| GET | `/dashboardAdmin` | Tableau de bord |
| GET | `/listeCandidats`, `/listePostes`, `/listeElecteurs` | Gestion de l'élection |
| POST | `/enregistrer-list` | Ajout d'une liste candidate |
| DELETE | `/deleteElecteur/{id}` | Suppression d'un électeur |

### Organisation du code Laravel

```
voteUGB/
├── app/Http/Controllers/
│   ├── login_controller.php        # accueil, connexion, déconnexion étudiant
│   ├── inscription_controller.php  # inscription + validation des données
│   ├── user_controller.php         # élections, détail d'une liste, vote, résultats
│   └── AdminController.php         # connexion admin, tableau de bord, gestion
├── app/Models/                     # Etudiant, EtudiantOfficiel, UFR, Listes,
│                                   # MembresListe, Votes, VoteEtudiant, Admin
├── database/migrations/            # schéma de la base
├── database/seeders/UgbvoteSeeder.php  # jeu de données de démonstration
├── resources/views/
│   ├── ugbvote.blade.php           # accueil
│   ├── user/                       # login, inscription, election, detailListe,
│   │                               # systemevote, resultat
│   └── admin/                      # login, home (dashboard), candidates, postes, electeurs
├── public/js/                      # ajax.js (résultats temps réel), systemeVote.js, election.js…
├── public/jquery/                  # jQuery, jquery.validate, form-validation.js
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
- PHP ≥ 8.2 avec les extensions `pdo_mysql`, `mbstring`, `openssl`, `xml`
- Composer 2
- Node.js ≥ 18 et npm (pour Vite)
- MySQL / MariaDB (XAMPP, WAMP, Laragon… conviennent)

### Étapes

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/Metata08/projet_Dev_WEB_23-24.git
   ```

   ```bash
   cd projet_Dev_WEB_23-24/voteUGB
   ```

2. **Installer les dépendances**

   ```bash
   composer install
   ```

   ```bash
   npm install
   ```

3. **Configurer l'environnement** — copier le fichier d'exemple fourni (base MySQL `ugbvote` par défaut) et l'adapter si besoin (`DB_USERNAME`, `DB_PASSWORD`…) :

   ```bash
   cp .env.example .env
   ```

   puis générer la clé de l'application :

   ```bash
   php artisan key:generate
   ```

4. **Créer la base `ugbvote`** dans MySQL, puis lancer les migrations et le jeu de données :

   ```bash
   php artisan migrate --seed
   ```

   Pour repartir d'une base vide : `php artisan migrate:fresh --seed`.

5. **Lancer l'application**

   ```bash
   npm run dev
   ```

   ```bash
   php artisan serve
   ```

   L'application est accessible sur <http://localhost:8000>, l'espace administrateur sur <http://localhost:8000/admin>.

### Comptes de test

| Rôle | E-mail | Mot de passe |
|---|---|---|
| Étudiant | `ameth@gmail.com` | `ameth31` |
| Administrateur | `admin@gmail.com` | `admin123` |

Pour tester l'inscription, utiliser un code présent dans `etudiant_officiels` et non encore utilisé (voir `UgbvoteSeeder.php`).

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

**Pistes d'amélioration :**
- Protéger les routes administrateur par un middleware (`auth:admin`) et la page de vote par `auth`.
- Renforcer l'unicité du vote au niveau de la base (index unique `etudiant_id` + `vote_id`) en plus du contrôle applicatif.
- Contrôler les dates de début et de fin du scrutin avant d'accepter un vote.
- Ajouter la réinitialisation des votes et la modification/suppression des listes côté administrateur.
- Ajouter des tests automatisés (PHPUnit) sur l'inscription et le vote.

---

<p align="center">© 2025 UGB Vote — Université Gaston Berger de Saint-Louis</p>
