<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo 'firstname'.' '.'lastname'; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">RAPPORTS</li>
      <li class=""><a href="{{route('dashboardAdmin')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class=""><a href="votes.php"><span class="glyphicon glyphicon-lock"></span> <span>Votes</span></a></li>
      <li class="header">GERER</li>
      <li class=""><a href="{{route(('listeElecteurs'))}}"><i class="fa fa-users"></i> <span>Les électeurs</span></a></li>
      <li class=""><a href="{{route(('listePostes'))}}"><i class="fa fa-tasks"></i> <span>Postes</span></a></li>
      <li class=""><a href="{{route('listeCandidats')}}"><i class="fa fa-black-tie"></i> <span>Candidats</span></a></li>
      <li class="header">PARAMETRES</li>
      <li class=""><a href="#config" data-toggle="modal"><i class="fa fa-cog"></i> <span>Titre de l'élection</span></a></li>
      <li class="">
        <a href="{{route('logoutAdmin')}}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fa fa-sign-out-alt"></i> <span>Déconnexion</span>
        </a>
      </li>

      <form id="logout-form" action="{{ route('logoutAdmin') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
@include ('admin.includes.config_modal')