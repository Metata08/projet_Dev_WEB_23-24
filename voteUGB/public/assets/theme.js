/* Applique le thème mémorisé avant le premier affichage (évite tout flash). */
(function () {
  var racine = document.documentElement;
  racine.classList.add('js');
  try {
    if (localStorage.getItem('ugbvote-theme') === 'dark') {
      racine.setAttribute('data-theme', 'dark');
    }
  } catch (e) { /* stockage indisponible : thème clair */ }
})();
