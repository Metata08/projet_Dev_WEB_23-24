<header class="main-header">
  <!-- Logo -->
  <a href="{{ url('admin/home') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>C</b>P</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Système de vote</b></span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="" 
                 class="user-image" alt="User Image">
            <span class="hidden-xs"></span>

          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="" 
                   class="img-circle" alt="User Image">
              <p>
                <small>Member since </small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Update</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('logoutAdmin') }}" class="btn btn-default btn-flat"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                <form id="logout-form" action="{{ route('logoutAdmin') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

@include('admin.includes.profile_modal')
