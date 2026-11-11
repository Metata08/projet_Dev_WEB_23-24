/**
 * Génère une démonstration statique de UGB Vote (pour GitHub Pages).
 *
 * Le script parcourt l'application réelle (lancée avec `php artisan serve` sur une base
 * fraîchement « seedée ») comme le feraient un étudiant, une tête de liste et un
 * administrateur, enregistre le HTML de chaque page, puis réécrit les liens pour qu'ils
 * fonctionnent sans serveur. Les formulaires sont simulés par scripts/demo/demo.js.
 *
 * Usage : node scripts/demo-statique.mjs <dossier de sortie> [url de l'application]
 * Aucune dépendance : Node.js ≥ 18 suffit.
 */
import { cp, mkdir, writeFile } from 'node:fs/promises';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const SORTIE = process.argv[2] || 'demo';
const BASE = (process.argv[3] || 'http://127.0.0.1:8000').replace(/\/$/, '');
const RACINE = join(dirname(fileURLToPath(import.meta.url)), '..');

/* ---------- Petit client HTTP avec cookies et jeton CSRF ----------------- */
class Client {
  cookies = new Map();
  jeton = null;

  async requete(chemin, options = {}) {
    for (let saut = 0; saut < 6; saut++) {
      const reponse = await fetch(BASE + chemin, {
        ...options,
        redirect: 'manual',
        headers: { Accept: 'text/html,application/json', ...(options.headers || {}), Cookie: [...this.cookies].map(([n, v]) => `${n}=${v}`).join('; ') },
      });
      for (const ligne of reponse.headers.getSetCookie()) {
        const [paire] = ligne.split(';');
        const i = paire.indexOf('=');
        this.cookies.set(paire.slice(0, i), paire.slice(i + 1));
      }
      if (reponse.status >= 300 && reponse.status < 400) {
        chemin = new URL(reponse.headers.get('location'), BASE).pathname;
        options = {};
        continue;
      }
      const texte = await reponse.text();
      const m = texte.match(/name="csrf-token" content="([^"]+)"/);
      if (m) this.jeton = m[1];
      return { statut: reponse.status, texte, chemin };
    }
    throw new Error('Trop de redirections : ' + chemin);
  }

  get(chemin) { return this.requete(chemin); }

  post(chemin, champs = {}) {
    return this.requete(chemin, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ _token: this.jeton, ...champs }).toString(),
    });
  }
}

/* ---------- Correspondance URL de l'application → fichier statique ------- */
function fichierPour(chemin) {
  if (chemin === '/' || chemin === '/ugbvote') return 'index.html';
  if (chemin === '/resultats/json') return 'resultats.json';
  if (chemin === '/admin/stats.json') return 'admin-stats.json';
  return chemin.replace(/^\//, '').replace(/\//g, '-') + '.html';
}

// Où mène chaque formulaire dans la démo (aucune donnée n'est envoyée).
const SUITES = [
  [/^\/login$/, 'election.html'],
  [/^\/inscription$/, 'login.html'],
  [/^\/logout$/, 'login.html'],
  [/^\/systemevote\/\d+$/, 'a-vote.html'],
  [/^\/recu$/, 'recu-verifie.html'],
  [/^\/admin\/login$/, 'admin-tableau-de-bord.html'],
  [/^\/admin\/logout$/, 'admin.html'],
];

const pages = new Map(); // fichier → contenu brut

function reecrire(html) {
  const origine = BASE.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  const motif = new RegExp(`(href|src|action|data-resultats|data-tableau-de-bord)="(?:${origine})?(/[^"]*)"`, 'g');

  html = html.replace(motif, (tout, attribut, url) => {
    const [sansAncre, ancre = ''] = url.split('#');
    const chemin = sansAncre.split('?')[0];

    if (/^\/(assets|fonts|images|image)\//.test(chemin) || chemin === '/favicon.ico') {
      return `${attribut}="${chemin.slice(1)}"`;
    }
    if (attribut === 'action') {
      const suite = SUITES.find(([re]) => re.test(chemin));
      return `action="#" data-demo="${suite ? suite[1] : ''}"`;
    }
    const fichier = fichierPour(chemin);
    return `${attribut}="${pages.has(fichier) ? fichier : '#'}${ancre ? '#' + ancre : ''}"`;
  });

  return html
    .replace('</head>', '    <meta name="robots" content="noindex">\n    <link rel="stylesheet" href="demo.css">\n</head>')
    .replace('</body>', '    <script src="demo.js" defer></script>\n</body>');
}

async function capturer(client, chemin, fichier = fichierPour(chemin), statutAttendu = 200) {
  const { statut, texte } = await client.get(chemin);
  if (statut !== statutAttendu) throw new Error(`${chemin} → HTTP ${statut} (attendu ${statutAttendu})`);
  pages.set(fichier, texte);
  console.log('✓', chemin, '→', fichier);
}

/* ---------- Parcours ----------------------------------------------------- */
// 1) Visiteur
const visiteur = new Client();
for (const chemin of ['/', '/login', '/inscription', '/mot-de-passe-oublie', '/admin']) await capturer(visiteur, chemin);
await capturer(visiteur, '/page-introuvable', '404.html', 404);

// 2) Étudiante qui s'inscrit, consulte, compare puis vote
const etudiante = new Client();
await etudiante.get('/inscription');
await etudiante.post('/inscription', {
  prenom: 'Awa', nom: 'Ndiaye', code: 'p31 3001', ufr: '1', email: 'awa.demo@ugb.edu.sn',
  password: 'Campus2026', password_confirmation: 'Campus2026',
});
const connexion = await etudiante.post('/login', { email: 'awa.demo@ugb.edu.sn', password: 'Campus2026' });
if (connexion.chemin !== '/election') throw new Error('Connexion étudiante impossible (' + connexion.chemin + ')');

for (const chemin of ['/election', '/comparer', '/recu']) await capturer(etudiante, chemin);
for (const id of [1, 2, 3]) {
  await capturer(etudiante, '/detailListe/' + id);
  await capturer(etudiante, '/systemevote/' + id);
}

const vote = await etudiante.post('/systemevote/1', { confirmation: '1' });
pages.set('a-vote.html', vote.texte);
const recu = (vote.texte.match(/data-recu>([^<]+)</) || [])[1];
if (!recu) throw new Error('Reçu de vote introuvable après le vote');
console.log('✓ vote enregistré → a-vote.html');

await etudiante.get('/recu');
pages.set('recu-verifie.html', (await etudiante.post('/recu', { recu: recu.trim() })).texte);
await capturer(etudiante, '/resultat');
await capturer(etudiante, '/resultats/json');

// 3) Tête de liste : espace candidat
const candidate = new Client();
await candidate.get('/login');
await candidate.post('/login', { email: 'anta@gmail.com', password: 'anta31' });
await capturer(candidate, '/ma-liste');

// 4) Administrateur
const admin = new Client();
await admin.get('/admin');
const session = await admin.post('/admin/login', { email: 'admin@gmail.com', password: 'admin123' });
if (session.chemin !== '/admin/tableau-de-bord') throw new Error('Connexion administrateur impossible');

for (const chemin of ['/admin/tableau-de-bord', '/admin/stats.json', '/admin/electeurs', '/admin/listes', '/admin/codes', '/admin/scrutins']) {
  await capturer(admin, chemin);
}
for (const id of [1, 2, 3]) await capturer(admin, '/admin/listes/' + id);
for (const id of [1, 2, 3, 4]) await capturer(admin, `/admin/scrutins/${id}/proces-verbal`);
await capturer(admin, '/admin/journal'); // en dernier : le journal contient les actions ci-dessus

/* ---------- Écriture ----------------------------------------------------- */
await mkdir(SORTIE, { recursive: true });
for (const [fichier, contenu] of pages) {
  await writeFile(join(SORTIE, fichier), fichier.endsWith('.json') ? contenu : reecrire(contenu));
}
for (const dossier of ['assets', 'fonts', 'images', 'image']) {
  await cp(join(RACINE, 'public', dossier), join(SORTIE, dossier), { recursive: true });
}
await cp(join(RACINE, 'public', 'favicon.ico'), join(SORTIE, 'favicon.ico'));
await cp(join(RACINE, 'scripts', 'demo', 'demo.js'), join(SORTIE, 'demo.js'));
await cp(join(RACINE, 'scripts', 'demo', 'demo.css'), join(SORTIE, 'demo.css'));
await writeFile(join(SORTIE, '.nojekyll'), '');

console.log(`\n${pages.size} pages écrites dans ${SORTIE}/`);
