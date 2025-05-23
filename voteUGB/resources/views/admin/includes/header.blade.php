<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>Vote UGB - Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  	<!-- Tell the browser to be responsive to screen width -->
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
  	<!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.2-web/css/all.css') }}">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}}">
  	<!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  	<style type="text/css">
      .bold{
        font-weight:bold;
      }
      
      #candidate_list{
        margin-top:20px;
      }

      #candidate_list ul{
        list-style-type:none;
      }

      #candidate_list ul li{ 
        margin:0 30px 30px 0; 
        vertical-align:top
      }

      .clist{
        margin-left: 20px;
      }

      .cname{
        font-size: 25px;
      }
  	</style>
</head>