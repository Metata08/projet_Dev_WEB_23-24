@include('admin.includes.session')
@include('admin.includes.slugify')
@include('admin.includes.header')

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    @include('admin.includes.navbar')
    @include('admin.includes.menubar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
        Tableau de bord
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('dashboardAdmin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Tableau de bord</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>{{ $nombreDePostes }}</h3>
                <p>Nombre de postes</p>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
              <a href="#" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{ $nombreDeCandidats }}</h3>
                <p>Nombre de listes</p>
              </div>
              <div class="icon">
                <i class="fa fa-black-tie"></i>
              </div>
              <a href="#" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>{{ $nombreTotalElecteurs }}</h3>
                <p>Nombre total d'électeurs</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="#" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3>{{ $nombreElecteursVotants }}</h3>
                <p>Les électeurs ont voté</p>
              </div>
              <div class="icon">
                <i class="fa fa-edit"></i>
              </div>
              <a href="#" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row">
          <div class="col-xs-12">
            <h3>Décompte des votes
              <span class="pull-right">
                <a href="#" class="btn btn-success btn-sm btn-flat"><span class="glyphicon glyphicon-print"></span> Imprimer</a>
              </span>
            </h3>
          </div>
        </div>


        <div class="container my-4">
          <div id="chart-container">
            <canvas id="groupedBarChart"></canvas>
          </div>
        </div>
      </section>


    </div>
    <!-- Inclusions JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Passage de la variable positions via JSON -->
    <script>
      var positions = JSON.parse('{!! json_encode($positions) !!}');
    </script>

<script>
  var dataGrouped = positions;

  var positions = [...new Set(dataGrouped.map(item => item.position))]; // ["sat", "dakar"]
  var candidats = [...new Set(dataGrouped.map(item => item.candidat))]; // ["crak", "convergence"]

  var datasets = candidats.map(candidat => ({
    label: candidat,
    data: positions.map(position =>
      (dataGrouped.find(d => d.candidat === candidat && d.position === position) || {}).nombre_de_votes || 0
    ),
    backgroundColor: 'rgba(' + Math.floor(Math.random() * 255) + ',' +
                              Math.floor(Math.random() * 255) + ',' +
                              Math.floor(Math.random() * 255) + ', 0.7)',
    borderWidth: 1
  }));

  var ctx = document.getElementById('groupedBarChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: positions,
      datasets: datasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: { y: { beginAtZero: true } }
    }
  });
</script>

    @include('admin.includes.scripts')


    @include('admin.includes.footer')

  </div>

</body>

</html>