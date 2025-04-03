$(document).ready(function() {
    // Vérifier que 'positions' est défini et est un tableau
    if (typeof positions !== "undefined" && Array.isArray(positions)) {
        positions.forEach(function(position) {
            // Construit l'ID du canvas pour cette position
            var canvasId = 'position-' + position.id;
            var canvas = document.getElementById(canvasId);
            if (!canvas) {
                console.error("Canvas with id " + canvasId + " not found.");
                return;
            }
            var ctx = canvas.getContext('2d');
            // Création du graphique en barres horizontal (compatible avec Chart.js v3)
            var chart = new Chart(ctx, {
                type: 'bar', // type 'bar' avec indexAxis 'y' pour un horizontal bar chart
                data: {
                    labels: position.candidats.map(function(candidate) {
                        return candidate.nom;
                    }),
                    datasets: [{
                        label: 'Votes',
                        data: position.candidats.map(function(candidate) {
                            return candidate.nombre_de_votes;
                        }),
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y', // pour rendre le graphique horizontal
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    } else {
        console.error("Global variable 'positions' is not defined or is not an array.");
    }
});
