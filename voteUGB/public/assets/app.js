/* ==========================================================================
   UGB Vote — interactions
   Aucun script « inline » : tout passe par des attributs data-* (CSP stricte).
   ========================================================================== */
(function () {
  'use strict';

  var $ = function (sel, racine) { return (racine || document).querySelector(sel); };
  var $$ = function (sel, racine) { return Array.prototype.slice.call((racine || document).querySelectorAll(sel)); };
  var calme = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fr = new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 1 });

  /* ---------- Thème clair / sombre ------------------------------------- */
  $$('[data-theme-bascule]').forEach(function (bouton) {
    bouton.addEventListener('click', function () {
      var sombre = document.documentElement.getAttribute('data-theme') === 'dark';
      var appliquer = function () {
        if (sombre) { document.documentElement.removeAttribute('data-theme'); }
        else { document.documentElement.setAttribute('data-theme', 'dark'); }
        try { localStorage.setItem('ugbvote-theme', sombre ? 'light' : 'dark'); } catch (e) { /* ignoré */ }
      };
      if (document.startViewTransition && !calme) { document.startViewTransition(appliquer); } else { appliquer(); }
    });
  });

  /* ---------- Décalages d'animation (data-i → --i) --------------------- */
  $$('[data-i]').forEach(function (el) { el.style.setProperty('--i', el.getAttribute('data-i')); });

  /* ---------- En-tête & menu mobile ------------------------------------ */
  var entete = $('[data-entete]');
  if (entete) {
    var surDefilement = function () { entete.classList.toggle('defile', window.scrollY > 12); };
    window.addEventListener('scroll', surDefilement, { passive: true });
    surDefilement();
  }

  var bascule = $('[data-menu-bascule]');
  var menu = $('#menu');
  if (bascule && menu) {
    var fermerMenu = function () { menu.classList.remove('ouvert'); bascule.setAttribute('aria-expanded', 'false'); };
    bascule.addEventListener('click', function (e) {
      e.stopPropagation();
      var ouvert = menu.classList.toggle('ouvert');
      bascule.setAttribute('aria-expanded', String(ouvert));
    });
    document.addEventListener('click', function (e) { if (!menu.contains(e.target)) { fermerMenu(); } });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { fermerMenu(); } });
  }

  var admin = $('[data-admin]');
  if (admin) {
    $$('[data-admin-ouvrir]').forEach(function (b) { b.addEventListener('click', function () { admin.classList.add('menu-ouvert'); }); });
    $$('[data-admin-fermer]').forEach(function (b) { b.addEventListener('click', function () { admin.classList.remove('menu-ouvert'); }); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { admin.classList.remove('menu-ouvert'); } });
  }

  /* ---------- Compteurs animés ----------------------------------------- */
  function animerNombre(el, cible, duree) {
    var depart = parseFloat(String(el.textContent).replace(',', '.').replace(/[^\d.\-]/g, '')) || 0;
    cible = Number(cible) || 0;
    if (calme || depart === cible) { el.textContent = fr.format(cible); return; }
    var debut = null;
    var decimales = cible % 1 !== 0 || depart % 1 !== 0;
    function pas(t) {
      if (debut === null) { debut = t; }
      var p = Math.min((t - debut) / (duree || 1200), 1);
      var e = 1 - Math.pow(1 - p, 4);
      var v = depart + (cible - depart) * e;
      el.textContent = fr.format(decimales ? Math.round(v * 10) / 10 : Math.round(v));
      if (p < 1) { requestAnimationFrame(pas); } else { el.textContent = fr.format(cible); }
    }
    requestAnimationFrame(pas);
  }

  function remplirJauges(racine) {
    $$('[data-largeur]', racine).forEach(function (b) { b.style.width = Math.max(0, Math.min(100, parseFloat(b.getAttribute('data-largeur')) || 0)) + '%'; });
  }

  /* ---------- Apparitions au défilement -------------------------------- */
  function reveler(el) {
    el.classList.add('est-visible');
    $$('[data-compteur]', el).concat(el.matches('[data-compteur]') ? [el] : []).forEach(function (c) {
      var cible = c.getAttribute('data-compteur'); c.textContent = '0'; animerNombre(c, cible, 1600);
    });
    remplirJauges(el);
    if (el.hasAttribute('data-progres')) { el.style.setProperty('--progres', '1'); }
    var parent = el.closest('[data-progres]');
    if (parent) { parent.style.setProperty('--progres', '1'); }
  }

  var cibles = $$('.reveal, [data-progres]');
  if ('IntersectionObserver' in window && !calme) {
    var observateur = new IntersectionObserver(function (entrees) {
      entrees.forEach(function (entree) {
        if (entree.isIntersecting) { reveler(entree.target); observateur.unobserve(entree.target); }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    cibles.forEach(function (el) { observateur.observe(el); });
  } else {
    cibles.forEach(reveler);
  }
  // Jauges situées hors d'un bloc .reveal
  window.setTimeout(function () { remplirJauges(document); }, 2500);

  /* ---------- Halo & inclinaison 3D ------------------------------------ */
  var fin = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  if (fin && !calme) {
    $$('.halo').forEach(function (carte) {
      carte.addEventListener('pointermove', function (e) {
        var r = carte.getBoundingClientRect();
        carte.style.setProperty('--mx', (e.clientX - r.left) + 'px');
        carte.style.setProperty('--my', (e.clientY - r.top) + 'px');
      });
    });

    $$('[data-inclinaison]').forEach(function (zone) {
      var cible = $('[data-inclinaison-cible]', zone) || zone;
      var force = parseFloat(zone.getAttribute('data-inclinaison-force')) || 10;
      zone.addEventListener('pointermove', function (e) {
        var r = zone.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        cible.style.transform = 'perspective(1000px) rotateX(' + (-y * force).toFixed(2) + 'deg) rotateY(' + (x * force).toFixed(2) + 'deg) translateY(-6px)';
      });
      zone.addEventListener('pointerleave', function () { cible.style.transform = ''; });
    });
  }

  /* ---------- Effet d'onde sur les boutons ----------------------------- */
  document.addEventListener('pointerdown', function (e) {
    var b = e.target.closest ? e.target.closest('.btn') : null;
    if (!b || calme || b.disabled) { return; }
    var r = b.getBoundingClientRect();
    var onde = document.createElement('span');
    var taille = Math.max(r.width, r.height);
    onde.className = 'ripple';
    onde.style.width = onde.style.height = taille + 'px';
    onde.style.left = (e.clientX - r.left - taille / 2) + 'px';
    onde.style.top = (e.clientY - r.top - taille / 2) + 'px';
    b.appendChild(onde);
    window.setTimeout(function () { onde.remove(); }, 650);
  });

  /* ---------- Notifications -------------------------------------------- */
  $$('.toast').forEach(function (toast, i) {
    var fermer = function () { toast.classList.add('sort'); window.setTimeout(function () { toast.remove(); }, 400); };
    var b = $('.toast-fermer', toast);
    if (b) { b.addEventListener('click', fermer); }
    window.setTimeout(fermer, 6000 + i * 600);
  });

  /* ---------- Particules de l'accueil ---------------------------------- */
  var toile = $('[data-particules]');
  if (toile && !calme) {
    var ctx = toile.getContext('2d');
    var points = [];
    var L = 0, H = 0, dpr = Math.min(window.devicePixelRatio || 1, 2);
    var souris = { x: -999, y: -999 };

    var dimensionner = function () {
      var r = toile.getBoundingClientRect();
      L = r.width; H = r.height;
      toile.width = L * dpr; toile.height = H * dpr;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      var n = Math.min(70, Math.round(L * H / 16000));
      points = [];
      for (var i = 0; i < n; i++) {
        points.push({ x: Math.random() * L, y: Math.random() * H, vx: (Math.random() - 0.5) * 0.35, vy: (Math.random() - 0.5) * 0.35, r: 1 + Math.random() * 2 });
      }
    };

    var dessiner = function () {
      var sombre = document.documentElement.getAttribute('data-theme') === 'dark';
      var rgb = sombre ? '211,169,143' : '122,69,38';
      ctx.clearRect(0, 0, L, H);
      for (var i = 0; i < points.length; i++) {
        var p = points[i];
        p.x += p.vx; p.y += p.vy;
        if (p.x < 0 || p.x > L) { p.vx *= -1; }
        if (p.y < 0 || p.y > H) { p.vy *= -1; }
        var dxs = p.x - souris.x, dys = p.y - souris.y, ds = Math.sqrt(dxs * dxs + dys * dys);
        if (ds < 110) { p.x += dxs / ds * 1.2; p.y += dys / ds * 1.2; }
        ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, 6.283);
        ctx.fillStyle = 'rgba(' + rgb + ',0.45)'; ctx.fill();
        for (var j = i + 1; j < points.length; j++) {
          var q = points[j], dx = p.x - q.x, dy = p.y - q.y, d = dx * dx + dy * dy;
          if (d < 15000) {
            ctx.beginPath(); ctx.moveTo(p.x, p.y); ctx.lineTo(q.x, q.y);
            ctx.strokeStyle = 'rgba(' + rgb + ',' + (0.2 * (1 - d / 15000)).toFixed(3) + ')';
            ctx.lineWidth = 1; ctx.stroke();
          }
        }
      }
      if (!document.hidden) { requestAnimationFrame(dessiner); }
    };

    dimensionner();
    window.addEventListener('resize', dimensionner);
    window.addEventListener('pointermove', function (e) {
      var r = toile.getBoundingClientRect(); souris.x = e.clientX - r.left; souris.y = e.clientY - r.top;
    }, { passive: true });
    document.addEventListener('visibilitychange', function () { if (!document.hidden) { requestAnimationFrame(dessiner); } });
    requestAnimationFrame(dessiner);
  }

  /* ---------- Formulaires ---------------------------------------------- */
  $$('[data-oeil]').forEach(function (b) {
    b.addEventListener('click', function () {
      var champ = $('input', b.parentElement);
      var visible = champ.type === 'password';
      champ.type = visible ? 'text' : 'password';
      b.classList.toggle('visible', visible);
    });
  });

  $$('[data-active]').forEach(function (caseACocher) {
    var cible = $(caseACocher.getAttribute('data-active'));
    var maj = function () { if (cible) { cible.disabled = !caseACocher.checked; } };
    caseACocher.addEventListener('change', maj); maj();
  });

  function forceMotDePasse(v) {
    var n = 0;
    if (v.length >= 8) { n++; }
    if (/[a-zà-ÿ]/i.test(v) && /\d/.test(v)) { n++; }
    if (/[a-z]/.test(v) && /[A-Z]/.test(v) || /[^A-Za-z0-9]/.test(v)) { n++; }
    if (v.length >= 12) { n++; }
    return v.length ? Math.max(n, 1) : 0;
  }

  var regles = {
    nom: function (v) { return /^[A-Za-zÀ-ÿ\s'\-]+$/.test(v) ? '' : 'Lettres uniquement.'; },
    email: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v) ? '' : 'Adresse e-mail invalide.'; },
    motdepasse: function (v) { return v.length >= 8 && /[A-Za-zÀ-ÿ]/.test(v) && /\d/.test(v) ? '' : '8 caractères minimum, avec lettres et chiffres.'; },
    confirmation: function (v, champ) { var m = $(champ.getAttribute('data-miroir')); return m && m.value === v ? '' : 'Les mots de passe ne correspondent pas.'; }
  };

  function validerChamp(champ) {
    var bloc = champ.closest('.champ');
    if (!bloc) { return true; }
    var v = champ.value.trim();
    var message = '';
    if (champ.required && !v) { message = 'Ce champ est obligatoire.'; }
    else if (champ.getAttribute('data-regle') && regles[champ.getAttribute('data-regle')]) { message = regles[champ.getAttribute('data-regle')](champ.value, champ); }
    var zone = $('[data-erreur]', bloc);
    if (zone) { zone.textContent = message; }
    bloc.classList.toggle('invalide', !!message);
    bloc.classList.toggle('valide', !message && !!v);
    return !message;
  }

  $$('form[data-validation]').forEach(function (form) {
    var champs = $$('input:not([type=hidden]), select, textarea', form);
    champs.forEach(function (champ) {
      champ.addEventListener('blur', function () { validerChamp(champ); });
      champ.addEventListener('input', function () {
        if (champ.closest('.champ').classList.contains('invalide')) { validerChamp(champ); }
        var jauge = champ.getAttribute('data-force') && $(champ.getAttribute('data-force'));
        if (jauge) { jauge.setAttribute('data-niveau', forceMotDePasse(champ.value)); }
      });
    });
    form.addEventListener('submit', function (e) {
      var ok = champs.map(validerChamp).every(Boolean);
      if (!ok) {
        e.preventDefault(); e.stopImmediatePropagation();
        var premier = $('.champ.invalide input, .champ.invalide select', form);
        if (premier) { premier.focus(); }
      }
    });
  });

  /* ---------- Fenêtres modales & confirmations ------------------------- */
  $$('[data-ouvrir]').forEach(function (b) {
    b.addEventListener('click', function () { var d = $(b.getAttribute('data-ouvrir')); if (d && d.showModal) { d.showModal(); } });
  });
  $$('dialog [data-fermer]').forEach(function (b) { b.addEventListener('click', function () { b.closest('dialog').close(); }); });
  $$('dialog[data-ouverte]').forEach(function (d) { if (d.showModal) { d.showModal(); } });
  document.addEventListener('click', function (e) { if (e.target.tagName === 'DIALOG') { e.target.close(); } });

  function creer(balise, classe, texte) {
    var el = document.createElement(balise);
    if (classe) { el.className = classe; }
    if (texte) { el.textContent = texte; }
    return el;
  }

  $$('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (form.dataset.confirme === '1' || !window.HTMLDialogElement) { return; }
      e.preventDefault(); e.stopImmediatePropagation();
      var d = creer('dialog', 'modale');
      var corps = creer('div', 'modale-corps');
      corps.appendChild(creer('h2', 'titre-m', form.getAttribute('data-confirm-titre') || 'Confirmation'));
      corps.appendChild(creer('p', 'doux', form.getAttribute('data-confirm')));
      var actions = creer('div', 'modale-actions');
      var non = creer('button', 'btn', 'Annuler'); non.type = 'button';
      var oui = creer('button', 'btn ' + (form.hasAttribute('data-confirm-danger') ? 'btn-danger' : 'btn-primary'), form.getAttribute('data-confirm-action') || 'Confirmer'); oui.type = 'button';
      actions.appendChild(non); actions.appendChild(oui);
      d.appendChild(corps); d.appendChild(actions);
      document.body.appendChild(d);
      non.addEventListener('click', function () { d.close(); });
      oui.addEventListener('click', function () { form.dataset.confirme = '1'; d.close(); form.requestSubmit ? form.requestSubmit() : form.submit(); });
      d.addEventListener('close', function () { d.remove(); });
      d.showModal();
    });
  });

  // Anti double envoi : le bouton passe en état « chargement ».
  $$('form[data-envoi]').forEach(function (form) {
    form.addEventListener('submit', function () {
      var b = $('button[type=submit]', form);
      if (b) { b.classList.add('charge'); window.setTimeout(function () { b.disabled = true; }, 0); }
    });
  });
  window.addEventListener('pageshow', function () {
    $$('.btn.charge').forEach(function (b) { b.classList.remove('charge'); b.disabled = false; });
  });

  $$('[data-imprimer]').forEach(function (b) { b.addEventListener('click', function () { window.print(); }); });

  /* ---------- Recherche dans les tableaux ------------------------------ */
  var sansAccent = function (s) { return s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, ''); };
  $$('[data-filtre]').forEach(function (champ) {
    var table = $(champ.getAttribute('data-filtre'));
    if (!table) { return; }
    var lignes = $$('tbody tr', table);
    var aucun = $('[data-aucun]', table.parentElement);
    champ.addEventListener('input', function () {
      var q = sansAccent(champ.value.trim());
      var visibles = 0;
      lignes.forEach(function (tr) {
        var ok = sansAccent(tr.textContent).indexOf(q) !== -1;
        tr.hidden = !ok; if (ok) { visibles++; }
      });
      if (aucun) { aucun.hidden = visibles > 0; }
    });
  });

  /* ---------- Compte à rebours ----------------------------------------- */
  $$('[data-rebours]').forEach(function (zone) {
    var fin2 = new Date(zone.getAttribute('data-rebours')).getTime();
    var cases = { j: $('[data-j]', zone), h: $('[data-h]', zone), m: $('[data-m]', zone), s: $('[data-s]', zone) };
    var ecrire = function (el, v) {
      var t = String(v).padStart(2, '0');
      if (el.textContent !== t) { el.textContent = t; el.classList.remove('tic'); void el.offsetWidth; el.classList.add('tic'); }
    };
    var tic = function () {
      var reste = Math.max(0, Math.floor((fin2 - Date.now()) / 1000));
      ecrire(cases.j, Math.floor(reste / 86400));
      ecrire(cases.h, Math.floor(reste % 86400 / 3600));
      ecrire(cases.m, Math.floor(reste % 3600 / 60));
      ecrire(cases.s, reste % 60);
      if (reste === 0) { window.clearInterval(minuteur); window.setTimeout(function () { window.location.reload(); }, 1500); }
    };
    var minuteur = window.setInterval(tic, 1000); tic();
  });

  /* ---------- Résultats en direct -------------------------------------- */
  var CIRC = 2 * Math.PI * 50;

  function lireInitial(racine) {
    try { return JSON.parse($('[data-initial]', racine).textContent); } catch (e) { return null; }
  }

  function majLigne(li, ligne) {
    li.classList.toggle('en-tete', !!ligne.en_tete);
    var voix = $('[data-voix]', li), pct = $('[data-pct]', li), jauge = $('[data-largeur]', li);
    if (voix) { animerNombre(voix, ligne.votes, 900); }
    if (pct) { animerNombre(pct, ligne.pourcentage, 900); }
    if (jauge) { jauge.setAttribute('data-largeur', ligne.pourcentage); jauge.style.width = ligne.pourcentage + '%'; }
  }

  function sonder(url, intervalle, surDonnees) {
    var actif = true;
    var boucle = function () {
      if (document.hidden) { return; }
      fetch(url, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin', cache: 'no-store' })
        .then(function (r) { if (r.status === 401 || r.status === 419) { actif = false; window.location.reload(); } return r.ok ? r.json() : null; })
        .then(function (d) { if (d && actif) { surDonnees(d); } })
        .catch(function () { /* réseau momentanément indisponible : on réessaie au prochain tour */ });
    };
    window.setInterval(boucle, intervalle);
    document.addEventListener('visibilitychange', function () { if (!document.hidden) { boucle(); } });
  }

  var pageResultats = $('[data-resultats]');
  if (pageResultats) {
    var afficher = function (d) {
      $$('[data-total]', pageResultats).forEach(function (el) { animerNombre(el, d.total_votes, 900); });
      $$('[data-inscrits]', pageResultats).forEach(function (el) { animerNombre(el, d.inscrits, 900); });
      $$('[data-participation]', pageResultats).forEach(function (el) { animerNombre(el, d.participation, 900); });
      $$('[data-maj]', pageResultats).forEach(function (el) { el.textContent = d.maj; });

      var classement = $('[data-classement]', pageResultats);
      var decalage = 0;
      d.resultats.forEach(function (ligne, i) {
        var li = $('[data-liste="' + ligne.id + '"]', classement);
        if (li) {
          majLigne(li, ligne);
          var rang = $('.rang-num', li); if (rang) { rang.textContent = '#' + (i + 1); }
          classement.appendChild(li); // réordonne selon le classement courant
        }
        var legende = $('[data-legende="' + ligne.id + '"] [data-pct]', pageResultats);
        if (legende) { animerNombre(legende, ligne.pourcentage, 900); }
        var arc = $('[data-arc="' + ligne.id + '"]', pageResultats);
        if (arc) {
          var longueur = CIRC * ligne.pourcentage / 100;
          arc.style.strokeDasharray = longueur + ' ' + (CIRC - longueur);
          arc.style.strokeDashoffset = String(-decalage);
          decalage += longueur;
        }
      });
    };
    var initial = lireInitial(pageResultats);
    $$('[data-arc]', pageResultats).forEach(function (arc) { arc.style.strokeDasharray = '0 ' + CIRC; });
    if (initial) { window.setTimeout(function () { afficher(initial); }, 350); }
    sonder(pageResultats.getAttribute('data-resultats'), 5000, afficher);
  }

  var tableau = $('[data-tableau-de-bord]');
  if (tableau) {
    var afficherStats = function (d) {
      $$('[data-stat]').forEach(function (el) { var cle = el.getAttribute('data-stat'); if (cle in d) { animerNombre(el, d[cle], 900); } });
      $$('[data-maj]').forEach(function (el) { el.textContent = d.maj; });
      var jauge = $('[data-jauge-participation]');
      if (jauge) { var l = CIRC * d.participation / 100; jauge.style.strokeDasharray = l + ' ' + (CIRC - l); }
      (d.parUfr || []).forEach(function (bloc) {
        var zone = $('[data-ufr="' + bloc.ufr + '"]', tableau);
        if (!zone) { return; }
        var total = $('[data-ufr-total]', zone), part = $('[data-ufr-part]', zone);
        if (total) { animerNombre(total, bloc.total_votes, 900); }
        if (part) { animerNombre(part, bloc.participation, 900); }
        var ol = $('.classement', zone);
        bloc.resultats.forEach(function (ligne) {
          var li = $('[data-liste="' + ligne.id + '"]', zone);
          if (li) { majLigne(li, ligne); ol.appendChild(li); }
        });
      });
    };
    var jaugeInit = $('[data-jauge-participation]');
    if (jaugeInit) { jaugeInit.style.strokeDasharray = '0 ' + CIRC; }
    var stats = lireInitial(tableau);
    if (stats) { window.setTimeout(function () { afficherStats(stats); }, 350); }
    sonder(tableau.getAttribute('data-tableau-de-bord'), 8000, afficherStats);
  }

  /* ---------- Confettis après un vote ---------------------------------- */
  var zoneConfettis = $('[data-confettis]');
  if (zoneConfettis && !calme) {
    var c = zoneConfettis.getContext('2d');
    var W = zoneConfettis.width = window.innerWidth;
    var Ht = zoneConfettis.height = window.innerHeight;
    var couleurs = ['#522504', '#ab775b', '#d3a98f', '#f0e0d0', '#7a4526', '#ffffff'];
    var morceaux = [];
    for (var k = 0; k < 160; k++) {
      morceaux.push({
        x: W / 2 + (Math.random() - 0.5) * 120, y: Ht * 0.35,
        vx: (Math.random() - 0.5) * 16, vy: -Math.random() * 16 - 4,
        t: 6 + Math.random() * 8, rot: Math.random() * 6.28, vr: (Math.random() - 0.5) * 0.4,
        couleur: couleurs[k % couleurs.length], rond: Math.random() < 0.3
      });
    }
    var debutConf = performance.now();
    var pluie = function (t) {
      var age = t - debutConf;
      c.clearRect(0, 0, W, Ht);
      morceaux.forEach(function (m) {
        m.vy += 0.32; m.vx *= 0.99; m.x += m.vx; m.y += m.vy; m.rot += m.vr;
        c.save(); c.translate(m.x, m.y); c.rotate(m.rot);
        c.globalAlpha = Math.max(0, 1 - age / 4200);
        c.fillStyle = m.couleur;
        if (m.rond) { c.beginPath(); c.arc(0, 0, m.t / 2, 0, 6.283); c.fill(); }
        else { c.fillRect(-m.t / 2, -m.t / 4, m.t, m.t / 2); }
        c.restore();
      });
      if (age < 4200) { requestAnimationFrame(pluie); } else { zoneConfettis.remove(); }
    };
    requestAnimationFrame(pluie);
  }
})();
