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
         <!-- Bouton pour ouvrir le pop-up -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addListModal">
        Ajouter une liste
    </button>
      <h1>
        Listes
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboardAdmin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Listes</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
    @if(isset($listesC) && $listesC->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Liste</th>
                <th scope="col">Titre</th>
                <th scope="col">Programme</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listesC as $liste)
                <tr>
                    <td>{{ $liste->name_list }}</td>
                    <td>{{ $liste->titre }}</td>
                    <td>{{ $liste->programme }}</td>
                    <td>
                        <!-- Bouton de suppression -->
                        <form action="{{ route('deleteElecteur', $liste->id_list) }}" method="POST" style="display:inline;">
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
<!-- ./wrapper -->
 <!-- Fenêtre modale -->
<div class="modal fade" id="addListModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Ajouter une liste</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('enregistrerList') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre de la liste</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la liste</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="programme" class="form-label">Programme</label>
                        <textarea class="form-control" id="programme" name="programme" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ufr" class="form-label">UFR</label>
                        <select class="form-select" id="ufr" name="ufr" required>
                            <option value="">Veuillez sélectionner votre UFR</option>
                            @foreach(App\Models\UFR::all() as $ufr)
                                <option value="{{ $ufr->nom }}" {{ old('ufr') == $ufr->nom ? 'selected' : '' }}>
                                    {{ $ufr->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@include('admin.includes.scripts')
</body>
</html>
