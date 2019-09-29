@include('admin.toast')
@section('header.notLogin')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <title>{{ trans($router.'title') ?? '' }}</title>
    
        <!-- Custom fonts for this template-->
        <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    	<link href="{{ asset('sbadmin/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="{{ asset('sbadmin/css/admin.css') }}" rel="stylesheet">
  </head>
  <body class="bg-gradient-primary">
	@if ($errors->any())
		@yield('toast')
	@endif
@endsection
@section('header.login')
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{{ trans($router.'title') ?? '' }}</title>

  <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<link href="{{ asset('sbadmin/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin/css/admin.css') }}" rel="stylesheet">
    <?php if(isset($type)){ ?>
      	@switch($type)
      		@case('table')
      			  <link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
      			  <link href="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
      			@break
      		@default
      			<!-- nothing -->
      	@endswitch
	<?php } ?>

</head>

<body id="page-top">
	@if ($errors->any())
		@yield('toast')
	@endif
@endsection