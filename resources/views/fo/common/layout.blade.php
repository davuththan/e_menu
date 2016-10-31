<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Zac Constructor</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"name="viewport">
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	@include('fo.common.style')
</head>
	<body>
		
		<!-- top menu -->
			@include('fo.common.topmenu')
		<!-- /top menu -->

		<!-- bar -->
			@include('fo.common.header')
		<!-- /end bar -->
		
		<!-- slide show -->
			@include('fo.common.slideshow')   
		<!-- /end slide show -->
		
		<div class="clearfix"></div>
		<!-- content -->
			@yield('content')	
		<!-- end content -->
		 <div class="clearfix"></div>
		<!-- footer -->
		@include('fo.common.footer')	
		<!-- end footer -->

		<!-- srcipt -->
		@include('fo.common.script')
		<!-- end script -->
	</body>
</html>
