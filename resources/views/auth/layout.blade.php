<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}" />
  	<meta name="csrf-param" content="_token" />
    <title>{!!SITE_NAME!!}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    @include('Admin.common.style')    
  </head>
  <!-- <body class="hold-transition skin-blue sidebar-mini"> -->
  	<body class="hold-transition register-page">
  	@yield('content')
    
    @include('Admin.common.script')    
  </body>
</html>
