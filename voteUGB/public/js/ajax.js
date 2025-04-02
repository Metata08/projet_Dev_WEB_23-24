
function fetchResults() {
    $.ajax({
      url:resultatsUrl,
      method: "GET",
      dataType: "json",
      success: function(data) {
        $("#totalVotes").text(data.total_votes);

        let resultsHtml = "";
        data.resultats.forEach(result => {
          resultsHtml += `

                       <div class="row voting-card-wrapper d-flex justify-content-center align-items-center py-5">

      <div class="voting-card container  p-4 shadow rounded">
        <div
          class="card-header2 text-white rounded p-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
          <figure class="logo-container text-center mb-3 mb-md-0">
             <!-- <p class="logo-text fw-bold">Logo Liste</p> -->
          <img src="${imageCarte}" alt="Logo" class="list-image img-fluid">
          </figure>
          <div class="title-section text-center text-md-start">
            <h2 class="list-title fw-bold text-uppercase text-center">${result.liste}</h2>
          </div>
          <div class="image-container text-center">
            <img src="${logoVote}" alt="Logo" class="list-image img-fluid">
          </div>
        </div>

        <section class="progress-section">
        <div class=" progress-container" role="progressbar" aria-label="Example with label" aria-valuenow="${result.pourcentage}" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width:${result.pourcentage}%"></div>
        <p class="progress-text text-center text-nowrap ">${result.pourcentage}% (${result.votes} votes)</p>
        </div>
        </section>
       </div>
      </div>
                  `;
        });
        $("#resultatVote").html(resultsHtml);
      }
    });
  }

 
  $(document).ready(function() {
    fetchResults();
    setInterval(fetchResults, 5000); // Rafraîchir toutes les 5 secondes
  });