

function fetchResultsSystemeVote() {
  $.ajax({
    url: resultatsUrl,
    method: "GET",
    dataType: "json",
    success: function (data) {
      // $("#totalVotes").text(data.total_votes);

      let resultsHtml = "";
      data.resultats.forEach(result => {
        if (result.id == idList) {
          resultsHtml += ` 

        <div class=" progress-container" role="progressbar" aria-label="Example with label" aria-valuenow="${result.pourcentage}" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width:${result.pourcentage}%"></div>
        <p class="progress-text text-center text-nowrap ">${result.pourcentage}% (${result.votes} votes)</p>
        </div>
                  `;
        }
      });
      $("#resultatVoteSysteme").html(resultsHtml);
    }
  });
}


$(document).ready(function () {
  fetchResultsSystemeVote();
  setInterval(fetchResults, 5000); // Rafraîchir toutes les 5 secondes
});