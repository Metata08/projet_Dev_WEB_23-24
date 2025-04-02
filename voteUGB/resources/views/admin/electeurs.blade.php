@include('admin.includes.session')
@include('admin.includes.slugify')
@include('admin.includes.header')
<link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.2-web/css/all.css') }}">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('admin.includes.navbar')
  @include('admin.includes.menubar')

 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Electeurs
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboardAdmin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Electeurs</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
    @if(isset($etudiants) && $etudiants->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($etudiants as $etudiant)
                <tr>
                    <td>{{ $etudiant->id }}</td>
                    <td>{{ $etudiant->prenom }}</td>
                    <td>{{ $etudiant->nom }}</td>
                    <td>
                        <!-- Bouton de suppression -->
                        <form action="{{ route('deleteElecteur', $etudiant->id_etudiant) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE') <!-- Utiliser DELETE au lieu de POST -->
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet électeur ?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                        <!-- Bouton d'édition -->
                        <a href="#" class="btn btn-secondary">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">Aucun électeur trouvé.</p>
@endif
    </section>
  </div>
  
  @include('admin.includes.footer')

</div>
@include('admin.includes.scripts')
</body>
</html>
