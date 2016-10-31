<!-- <div id="cssmenu">
    <ul id="menu_list">
        <li class='active'><a href="{{url('/')}}">HOME</a></li>
      	<li><a href="{{url('service')}}">SERVICE</a></li>
		<li><a href="{{url('project_progress')}}">PROJECT</a></li>
		<li><a href="{{url('project_detail')}}">ACTIVITY</a></li>
		<li><a href="{{url('event_news')}}">EVENT & NEWS</a></li>
		<li><a href="{{url('gallery')}}">GALLERY</a></li>
		<li><a href="{{url('about')}}">ABOUT US</a></li>
    </ul>
</div> -->

<header class="main-header">
	<div class="backbg-color">
		<div class="navigation-bar">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<!--navigation starts-->
				<nav class="navbar navbar-default">
					<div class="navbar-header">
					    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					       <span class="icon-bar"></span>
					       <span class="icon-bar"></span>
					       <span class="icon-bar"></span>
					    </button>
					    <!-- <a class="navbar-brand" href="#"><span class="grey">Li</span>the</a> -->
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						
					    <div class="col-lg-12 col-md-12 col-sm-12 col-lg-offset-2">
							 <ul class="nav navbar-nav text-center">
						     	<li class="active"><a href="{{url('/')}}">Home</a></li>
						        <li><a href="{{url('service')}}">SERVICE</a></li>
						        <li><a href="{{url('project_detail')}}">Activity</a></li>
								<li><a href="{{url('event_news')}}">Event & News</a></li>
								<li><a href="{{url('gallery')}}">Gallery</a></li>
								<li><a href="{{url('about')}}">About Us</a></li>
						    </ul>
						</div>
						<!-- <div class="col-lg-2 col-md-2 col-sm-2">
							 <ul class="nav navbar-nav">
						    </ul>
						</div> -->
					</div>
				</nav>
				<!--navigation ends-->
			</div>
		</div>	
</header>

<style type="text/css">
.navbar-header.navbar-toggle{
	border-radius: none !important;
}
.main-header{}
.main-header .navigation-bar{margin-top:80px;width: 100%;}
.main-header .navigation-bar .navbar-default {background-color:#e41c47;border-color: #e41c47;border-radius: 2px 2px; text-align: center;}
/*.main-header .navigation-bar .navbar-default .navbar-brand {text-transform: uppercase;font-size: 28px;line-height: 20px;font-weight: 300;}*/
.main-header .navbar{border-radius: none !important;}
.main-header .navigation-bar .navbar{margin:0px;padding:0px 0px;}
.main-header .navigation-bar .navbar-default .navbar-nav > li{
		/*padding: 0px 10px;*/
		text-align: center;
}
.main-header .navigation-bar .navbar-default .navbar-nav > li > a {text-transform: uppercase;
	font-size: 14px;font-weight:500;letter-spacing: 0.5px;color: white;}
.main-header .navigation-bar .navbar-default .navbar-nav > .active > a{color: #8FA5AF;	
	/*background-color: #fff;*/
}
/*ul .nav .navbar-nav li a:hover{background-color:#f00 !important;}*/
.main-header .navigation-bar .navbar-default .navbar-nav > li > a:hover{background: rgba(203,0,44,0.5) !important; }
.navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:focus, .navbar-default .navbar-nav>.active>a:hover{background:rgba(0,0,0,0.1);}
.navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover{background-color: #d51143 !important;}
@media all and (max-width: 800px), only screen and (-webkit-min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min--moz-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (-o-min-device-pixel-ratio: 2/1) and (max-width: 1024px), only screen and (min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min-resolution: 192dpi) and (max-width: 1024px), only screen and (min-resolution: 2dppx) and (max-width: 1024px){
 	.main-header .navigation-bar .navbar-default .navbar-nav > li{padding: 0px 5px !important;margin-left: 5px !important;}
 	.main-header .navigation-bar .navbar{margin:0px !important;padding:0px 0px !important;}
 	.navbar-toggle{border-radius: 4px !important;}
 	.main-header .navigation-bar{
 		margin-top: 80px !important;
 		width: 100% !important;
 	}
 	.main-header .navigation-bar .navbar-default .navbar-nav > li > a {
 		text-transform: uppercase;
		font-size: 11px !important;
		font-weight:500;
		letter-spacing: 0px !important;
		color: white;
	}
	.callbacks .caption{
		padding: 0px !important;
		padding: 0px !important;
	}
}
@media all and (max-width: 360px), only screen and (-webkit-min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min--moz-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (-o-min-device-pixel-ratio: 2/1) and (max-width: 1024px), only screen and (min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min-resolution: 192dpi) and (max-width: 1024px), only screen and (min-resolution: 2dppx) and (max-width: 1024px){
 	.main-header .navigation-bar{
 		margin-top: 0px !important;
 		width: 100% !important;
 	}
 	.company-logo{text-align: center !important;padding-bottom: 20px !important;}
 	.footer_right{text-align: center !important;}
}
/*.grey {
	color: #F84B4A;
}
*/
/*.main-header .banner-text
{
	width: 100%;
	float: left;
	padding-top: 200px;
}*/
/*.banner-info h2
{
	color: #fff;
	font-size: 65px;
	padding-bottom: 150px;
}
.banner-info h2 span
{
	font-weight: 600;
	font-family: 'Roboto Slab', serif;;
}*/
/*.main-header .banner-text .banner-heading h3
{
	font-size: 28px;
	color: #FFF;
	padding-bottom: 15px;
}*/

</style>
<!--  <script>					
	$("#cssmenu").click(function(){
		$("ul li").Toggle("hide")
	});
</script> -->
<script>
// $("#cssmenu").click(function(){
// 	$("#menu_list").toggle("hide");
// });
</script>