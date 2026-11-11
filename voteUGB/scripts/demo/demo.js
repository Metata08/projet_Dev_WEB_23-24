/* Démonstration statique : simule les formulaires, rien n'est envoyé ni enregistré. */
(function () {
  'use strict';

  // Identifiants de démonstration préremplis.
  var comptes = { 'login.html': ['awa.demo@ugb.edu.sn', 'Campus2026'], 'admin.html': ['admin@gmail.com', 'admin123'] };
  var page = location.pathname.split('/').pop() || 'index.html';
  if (comptes[page]) {
    var email = document.getElementById('email'), mdp = document.getElementById('password');
    if (email && mdp) { email.value = comptes[page][0]; mdp.value = comptes[page][1]; }
  }

  function avertir(texte) {
    var zone = document.querySelector('.toasts');
    if (!zone) { return; }
    var toast = document.createElement('div');
    toast.className = 'toast toast-succes';
    toast.setAttribute('role', 'status');
    toast.textContent = texte;
    zone.appendChild(toast);
    window.setTimeout(function () { toast.remove(); }, 4500);
  }

  document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!form.hasAttribute('data-demo')) { return; }
    e.preventDefault();
    var suite = form.getAttribute('data-demo');
    if (suite) { window.setTimeout(function () { location.href = suite; }, 450); return; }
    avertir('Démonstration : cette action n\'est pas enregistrée.');
    window.setTimeout(function () {
      Array.prototype.forEach.call(form.querySelectorAll('.btn.charge'), function (b) { b.classList.remove('charge'); b.disabled = false; });
      var dialogue = form.closest('dialog'); if (dialogue) { dialogue.close(); }
      delete form.dataset.confirme;
    }, 50);
  });

  // Bandeau de navigation entre les trois rôles.
  var bandeau = document.createElement('nav');
  bandeau.className = 'demo-bandeau sans-impression';
  bandeau.setAttribute('aria-label', 'Démonstration');
  [['Démo statique', null], ['Étudiant', 'election.html'], ['Candidat', 'ma-liste.html'], ['Admin', 'admin-tableau-de-bord.html']].forEach(function (lien) {
    var el = document.createElement(lien[1] ? 'a' : 'strong');
    el.textContent = lien[0];
    if (lien[1]) { el.href = lien[1]; }
    bandeau.appendChild(el);
  });
  document.body.appendChild(bandeau);
})();
