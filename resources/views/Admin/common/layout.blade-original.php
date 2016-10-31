<!DOCTYPE html>
<html>
  <head>
	
    <!-- Favico ICon All Tablet -->
  <link rel="apple-touch-icon" sizes="57x57" href="/client/icon-favico/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/client/icon-favico/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/client/icon-favico/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/client/icon-favico/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/client/icon-favico/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/client/icon-favico/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/client/icon-favico/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/client/icon-favico/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/client/icon-favico/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/client/icon-favico/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/client/icon-favico/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/client/icon-favico/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/client/icon-favico/favicon-16x16.png">
  <link rel="manifest" href="/client/icon-favico/manifest.json">
  <!-- Meta Device -->
  <meta name="csrf-token" content="{{ csrf_token()}}" />
  <meta name="csrf-param" content="_token" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="AWA provide special services to all customers." />
  <meta name="keywords" content="Free WiFi, Free Snack, Free Fresh Water, Passanger Insurance, GPS Speed Limitation" />  
  <!-- Medta Icon -->
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="client/icon-favico/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

    <title>Y5ADVERTISING | Quiz Engine</title>
    
    <!-- ########################### Admin Style ############################-->
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/css/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!-- DataTables -->
    <link rel="stylesheet" href="/css/admin/plugins/datatables/dataTables.bootstrap.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="/css/admin/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="/css/admin/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{url('cashier/css/admin/plugins/datepicker/datepicker3.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{url('cashier/css/admin/plugins/daterangepicker/daterangepicker-bs3.css')}}">
  

    <?php
      $group_id = Auth::user()->group_id;
      $flag_group_id = DB::table('group_user')->where('id', $group_id)->pluck('status');
      if($flag_group_id==2){
    ?>
      
      <!-- ##########################Style Cashier############################# -->
      <!-- ########Bootstrap -->
      <!-- <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css?v=3.3.5')}}"/> -->
      <!-- <link rel="stylesheet" type="text/css" href="{{url('/cashier/css/admin/bootstrap/css/bootstrap.min.css?v=3.3.5')}}"/> -->
      <!-- ########Normal Style -->
      <link rel="stylesheet" type="text/css" href="{{url('/cashier/css/style.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{url('/cashier/css/style_mobile.css')}}"/>
      <!-- Drop Down Way -->
      <link rel="stylesheet" type="text/css" href="{{url('/cashier/css/dropdown/dropDownBooking.css')}}"/>
      <!-- Bootstrap 3.3.5 -->
      <!-- <link rel="stylesheet" href="{{url('cashier/css/admin/bootstrap/css/bootstrap.min.css')}}"> -->
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{url('cashier/css/admin/dist/css/AdminLTE.min.css')}}">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="{{url('cashier/css/admin/dist/css/skins/_all-skins.min.css')}}">
     
      <!-- ##########################END Style Cashier############################# -->
    <?php
      }else{
    ?>
      <!-- ########################### Admin Style ############################-->
      <!-- Bootstrap 3.3.5 -->
      <!-- <link rel="stylesheet" href="/css/admin/bootstrap/css/bootstrap.min.css"> -->
      <!-- Theme style -->
      <link rel="stylesheet" href="/css/admin/dist/css/AdminLTE.min.css">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="/css/admin/dist/css/skins/_all-skins.min.css">

    <?php
      }
    ?>

    <!-- jQuery 2.1.4 -->
    <script src="/css/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Use for deleting by tag <a> -->
    <script src="/js/rails.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <!-- header -->
      @include('Admin.common.header')
      <!-- Left side column. contains the logo and sidebar -->
      @include('Admin.common.sidebar')
      
      @yield('content')

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="{{ url('/') }}" target="_blank">AWA</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
       @include('Admin.common.control_sidebar')
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    
    <!-- jQuery 2.1.4 -->
    <script src="/css/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="/css/admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="/css/admin/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="/css/admin/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/css/admin/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="/css/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="/css/admin/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="/css/admin/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="/css/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="/css/admin/plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="/css/admin/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/css/admin/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!--<script src="/css/admin/dist/js/demo.js"></script>-->
    <script src="{{url('cashier/css/admin/dist/js/demo.js')}}"></script>
     <!-- DataTables -->
    <script src="/css/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/css/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>

    <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
      }
    </script>
   <!-- DataTables -->
    <script src="/css/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/css/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>

    <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });
    </script>

  </body>
  <style>
	 .validate_label_red{color:red}
  </style>
</html>