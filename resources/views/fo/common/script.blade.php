	<script src="{{url('lib/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <!-- <script src="{url('js/jquery-1.9.1.min.js')}}"></script> -->

<!-- gallery -->
<!-- <script src="lib/gallery/web/js/jquery-1.12.0.min.js"></script> -->
<link href="lib/gallery/web/css/style.css" rel='stylesheet' type='text/css' />
<link href="lib/gallery/web/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="lib/gallery/web/js/wow.min.js"></script>
<script>
new WOW().init();
</script>


<script src="lib/gallery/web/js/modernizr.custom.97074.js"></script>
<script src="lib/gallery/web/js/jquery.chocolat.js"></script>
<link rel="stylesheet" href="lib/gallery/web/css/chocolat.css" type="text/css" media="screen" charset="utf-8">

<!--light-box-files -->
<script type="text/javascript">
  $(function() {
    $('.gallery-bottom a').Chocolat();
  });
</script>


	<!-- include('common.style') -->
	<!-- script Slide SHow -->
	<!-- Custom Fonts -->
	<!-- <script src="lib/slide_update/js/jquery-latest.min.js"></script>  -->
	<!--====================script menu======================== -->
	<script src="lib/slide_update/js/script.js"></script>

	<script src="lib/slide_update/js/responsiveslides.min.js"></script>
	<!--======================slide header=============================== -->
	<script>
	    $(function () {
	      $("#slider").responsiveSlides({
	      auto: true,
	      pager: false,
	      nav: true,
	      speed: 500,
	      namespace: "callbacks",
	      before: function () {
	        $('.events').append("<li>before event fired.</li>");
	      },
	      after: function () {
	        $('.events').append("<li>after event fired.</li>");
	      }
	      });
	    });
	</script>
	  
	<!--////////////////////////////////////Header-->

<!-- jQuery 2.1.4 -->
	<!-- jQuery UI 1.11.4 -->
	<script src="{{url('lib/AdminLTE/plugins/jQueryUI/jquery-ui.min.js')}}"></script>

	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script> $.widget.bridge('uibutton', $.ui.button);</script>
	<!-- Bootstrap 3.3.5 -->
	<script src="{{url('lib/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
	<!-- Morris.js charts -->
	<script src="{{url('lib/plugins/js/raphael-min.js')}}"></script>
	<script src="{{url('lib/AdminLTE/plugins/morris/morris.min.js')}}"></script>
	<!-- Sparkline -->
	<script src="{{url('lib/AdminLTE/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{url('lib/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{url('lib/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('lib/AdminLTE/plugins/knob/jquery.knob.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('lib/plugins/js/moment.min.js')}}"></script>
<script src="{{url('lib/AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{url('lib/AdminLTE/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url('lib/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{url('lib/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('lib/AdminLTE/plugins/fastclick/fastclick.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('lib/AdminLTE/dist/js/app.min.js')}}"></script>
	
<!--======================= anmation Effect================== -->
<script src="{{url('js/wow.min.js')}}"></script>

    
<!-- AdminLTE for demo purposes -->
<script src="{{url('lib/AdminLTE/dist/js/demo.js')}}"></script>


<!-- JS -->
<!-- <script type="text/javascript" src="assets/js/jquery.min.js" type="text/javascript"></script> -->
<!-- <script type="text/javascript" src="assets/js/bootstrap.min.js" type="text/javascript"></script> -->
<script type="text/javascript" src="{{url('assets/js/scripts.js')}}"></script>
<!-- Isotope - Portfolio Sorting -->
<script type="text/javascript" src="{{url('assets/js/jquery.isotope.js')}}" type="text/javascript"></script>



<!--project detail-->

<!-- <script src="lib/carousel/js/vendor/jquery-1.10.1.min.js"></script> -->
<!--  <script src="js/jquery.easing-1.3.js"></script>
<script src="js/bootstrap.js"></script> -->
<script src="{{url('lib/carousel/js/plugins.js')}}"></script>
<script src="{{url('lib/carousel/js/main.js')}}"></script>

<!--============= carousel slide-PROJECT DETAIL=========== -->
<script type="text/javascript" src="{{url('lib/carousel_slide/js/jssor.slider.min.js')}}"></script>
<script>
    jssor_1_slider_init = function() {
        var jssor_1_SlideshowTransitions = [
          {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
        ];
        
        var jssor_1_options = {
          $AutoPlay: true,
          $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: jssor_1_SlideshowTransitions,
            $TransitionsOrder: 1
          },
          $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$
          },
          $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $Cols: 10,
            $SpacingX: 8,
            $SpacingY: 8,
            $Align: 360
          }
        };
        
        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
        
        //responsive code begin
        function ScaleSlider() {
            var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 800);
                jssor_1_slider.$ScaleWidth(refSize);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }
        ScaleSlider();
        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        //responsive code end
    };
</script>
<script>
jssor_1_slider_init();
</script>



