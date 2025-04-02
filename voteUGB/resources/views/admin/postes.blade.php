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
        Postes
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboardAdmin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Postes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
    </section>
  </div>
  
  @include('admin.includes.footer')

</div>
@include('admin.includes.scripts')
</body>
</html>