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
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboardAdmin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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

      <div class="row">
        <!-- Exemple d'affichage des positions et des résultats des votes -->
      @foreach($positions as $position)
            <div>
                <h4>{{ $position->position }}</h4>
                <p>{{ $position->candidat }}: {{ $position->nombre_de_votes }} votes</p>
            </div>
        @endforeach
      </div>
    </section>
  </div>
  
  @include('admin.includes.footer')

</div>
<!-- ./wrapper -->

@include('admin.includes.scripts')
<script>
$(document).ready(function() {
    @foreach($positions as $position)
    var ctx = document.getElementById('position-{{ $position->id }}').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: {!! json_encode($position->candidats->pluck('nom')) !!},
            datasets: [{
                label: 'Votes',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: {!! json_encode($position->candidats->pluck('nombre_de_votes')) !!}
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    @endforeach
});

</script>

</body>
</html>