<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}" />
  	<meta name="csrf-param" content="_token" />
    <title>ZAC Resource</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    @include('bo.common.style')    
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
  	<!-- <div ng-view></div> -->
    <div class="wrapper">

	@include('bo.common.header')
      <!-- Left side column. contains the logo and sidebar -->
	@include('bo.common.sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	@yield('content')
        </section>
      </div><!-- /.content-wrapper -->
        @include('bo.common.footer')

		@include('bo.common.control_sidebar')
      
    </div><!-- ./wrapper -->

    @include('bo.common.script')    
  </body>
</html>
