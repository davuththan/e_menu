<!DOCTYPE html>

    <html>
    
	    <head>
	        <title>{{SITE_NAME}}</title>

			<!-- Tell the browser to be responsive to screen width -->
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			<meta http-equiv="Content-Type" content="{{HTTP_EQUIV_CONTENT_TYPE}}" />
			<meta name="viewport" content="{{MATA_VIEW_REPORT}}">
			<meta name="description" content="{{META_DESCRIPTION}}" />
			<meta name="keywords" content="{{META_KEYWORDS}}" />  
				
			<link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}">
			<!-- custom -->
			<link rel="stylesheet" type="text/css" href="{{url('css/mq_customer.css')}}">
			<!-- carousel -->
			<link rel="stylesheet" type="text/css" href="{{url('carousel/slick.css')}}">
			<link rel="stylesheet" type="text/css" href="{{url('carousel/slick-theme.css')}}">
			<!-- font-awesome -->
			<link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}">

			<!-- javascript -->
			<script type="text/javascript" src="{{url("js/jquery-1.9.1.min.js")}}"></script>
			<script type="text/javascript" src="{{url("js/bootstrap.min.js")}}"></script>
	    </head>

    <body>

    	<!-- container	 -->
    	<div class="container-fluid">

    		<!-- header -->
    		<div class="header" style="padding: 10px 0 20px 0;color:#a9a8a8;">

    			<div class="col-sm-12" style="font-size:18px;">
    				<div class="col-sm-8 col-sm-offset-1">
    					<div class="col-sm-offset-5" style="padding:10px 0;">
	    					<center>
		    					<!-- logo -->
				    			<img width="200px" src="{{url('images/upload/icon/logo.png')}}">
	    					</center>
    					</div>
    				</div>
    				<div class="hidden-lg hidden-md hidden-sm hidden-xs">
    					<div class="contact-info" style="margin-bottom:10px;border-bottom: 1px solid #999;border-radius: 6;width:300px;padding:0 0;">FOLLOW US ON</div>
    					<div class="btn btn-primary" style="border-radius: 50%;background-color: #e3b65d;border-color: #e3b65d">
    						<i class="fa fa-facebook" aria-hidden="true"></i>
						</div>
    					<div class="btn btn-danger" style="border-radius: 50%;background-color: #e3b65d;border-color: #e3b65d;">
    						<i class="fa fa-wa fa-google-plus"></i>
    					</div>
    					<div class="btn btn-danger" style="border-radius: 50%;background-color: #e3b65d;border-color: #e3b65d;">
    							<i class="fa fa-twitter" aria-hidden="true"></i>
						</div>
						<div class="btn btn-danger" style="border-radius: 50%;background-color: #e3b65d;border-color: #e3b65d;">
    							<i class="fa fa-twitter" aria-hidden="true"></i>
						</div>

    				</div>
    				<div class="clearfix"></div>
    			</div>

    			<div class="clearfix"></div>
    		</div>

    		<!-- footer_container -->
    		<div class="footer_container">
    			<!-- side-menu-category -->
    			<div class="hidden-xs col-lg-3 col-md-3 col-sm-4">
    				<!-- category_inner -->
    				<div class="category_inner" style="border-radius: 6px;padding-bottom: 20px;">
	    				<div class="category_name" style="border-radius: 6px;text-align: center;font-size:20px;padding-bottom:15px;border-bottom:1px solid #999;"><i class="fa fa-cutlery" aria-	hidden="true"></i>
							 MENU CATEGORY
						</div>

	    				<!-- <div style="border:1px solid #f00;">sadf</div> -->
	    				<!-- <ul class="ul-category">
	    					<li><a href=""><img width="50px" src="{{url('images/upload/icon/food.png')}}"></a></li>
	    				</ul> -->

	    				@foreach($product_categories as $product_category)
		    				<div class="row" style="margin-top:20px;margin-left:15px;">
			    				<div class="col-sm-12">
			    					<ul class="ul-cat-list">
			    						<li><a onclick="initCat({{$product_category->id}});" href="javascript:void(0);"><i class="fa fa-wa fa-chevron-right"></i> {!!$product_category->name!!}</a></li>
			    					</ul>
			    				</div>
			    				<div class="clearfix"></div>
			    			</div>
		    			@endforeach
    				</div>
    			</div>

    			<!-- content-menu -->
    			<div class="col-lg-9 col-md-9 col-sm-8">
    				<div class="-row">
	    				<!-- subcategory -->
	    				<!-- <div class="-hidden-xs sub-category"​ style="border-radius: 6px;color:#f2e191;background-color:#393639;padding:17px;z-index: 999;"> -->
	    				<div class="-hidden-xs sub-category"​ style="border-radius: 6px;color:#f2e191;background-color:#393639;padding:10px;z-index: 999;">

	    					<div style="position: relative;">
	    						<div style="float: left;position: absolute;left:0;top:0px;">
	    							<img width="25px" src="{{url('images/upload/icon/Arrow-Forward-Left.png')}}">
	    						</div>

	    						<div style="float: right;position: absolute;right:0;top:0px;">
	    							<img width="25px" src="{{url('images/upload/icon/Arrow-Forward-Right.png')}}">
	    						</div>
		    					<center>
		    						<div id="product_subCat_html">
			    						@foreach($product_sub_categories as $product_sub_category)
					    					<!-- col-sm-3 -->
					    					<div class="col-lg-3 col-md-4 col-sm-3">
						    					<div class="sub-category-box"><a onclick="initSubCat({{$product_sub_category->id}})" href="javascript:void(0);"><i class="fa fa-wa fa-cutlery"></i> {!!$product_sub_category->name_en!!} / {!!$product_sub_category->name_kh!!}</a></div>
					    					</div>
				    					@endforeach
				    				</div>

			    					<!-- <div class="col-lg-3 col-md-4 col-sm-3">
				    					<div class="sub-category-box"><i class="fa fa-wa fa-cutlery"></i> Korean​ /​ កូរ៉េ</div>
			    					</div>

			    					<div class="col-lg-3 col-md-4 col-sm-3">
				    					<div class="sub-category-box"><i class="fa fa-wa fa-cutlery"></i> Thai/ថៃ</div>
			    					</div>

			    					<div class="col-lg-3 col-md-4 col-sm-3">
				    					<div class="sub-category-box"><i class="fa fa-wa fa-cutlery"></i> Vietnam/វៀតណាម</div>
			    					</div> -->
			    					
			    				</center>
	    					</div>
		    				<div class="clearfix"></div>
	    				</div>

	    				<div class="row" style="margin-top:10px;position: relative;">
	    					<!--  -->
	    					<!-- <div style="position: absolute;left:10px;top:40%;z-index: 1;opacity: 0.7;"><img width="50px" src="{{url('images/upload/icon/arrow-lg-left.png')}}"></div>

	    					<div style="position: absolute;right:10px;top:40%;z-index: 1;opacity: 0.7;"><img width="50px" src="{{url('images/upload/icon/arrow-lg-right.png')}}"></div> -->
			    			<!-- ####col-sm-4 -->
			    			<div id="sub_cat_food_html">
			    				@foreach($products as $product)
				    				<div class="col-lg-4 col-sm-6 col-xs-6 col-md-4" style="padding-bottom:20px;">
						    			<div class="" style="position: relative;" data-toggle="modal" data-target="#myModal">
							    				<img class="img-responsive" src="{{url('images/upload/food/1.jpg')}}">
							    				<div class="bg_img" style="color:#f2e191;">
							    					<div class="pull-left">
							    						<span>{!!$product->name_en!!}</span><br>
							    						<span​​ style="font-size:11px;">{!!$product->name_kh!!}</span>
							    					</div>

							    					<div class="pull-right">
							    						<span style="color:#f2e191;">
							    							$ {!!$product->price!!}.00
							    						</span>
							    					</div>
							    					<div class="clearfix"></div>
							    				</div>
						    			</div>
					    			</div>
				    			@endforeach
			    			</div>
			    			<!-- <div class="col-lg-4 col-sm-6 col-xs-6 col-md-4" style="padding-bottom:20px;">
				    			<div class="" style="position: relative;" data-toggle="modal" data-target="#myModal">
					    				<img class="img-responsive" src="{{url('images/upload/food/1.jpg')}}">
					    				<div class="bg_img" style="color:#f2e191;">
					    					<div class="pull-left">
					    						<span>Sushi Japan</span><br>
					    						<span​​ style="font-size:11px;">សូសីុ</span>
					    					</div>

					    					<div class="pull-right"><span style="color:#f2e191;">$12.00</span></div>
					    					<div class="clearfix"></div>
					    				</div>
				    			</div>
			    			</div> -->
			    		</div>

		    			<!-- Modal -->
					   <div class="modal fade" id="c" role="dialog" style="z-index: 9999;padding-top: 2%;">
					    <div class="modal-dialog">
					    
					      <!-- Modal content-->
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title text-center" style="font-weight: bold;font-size:20px;">Sushi Japan/សូសីុ13$</h4>
					        </div>
					        <div class="modal-body">
					        	<!-- row -->
					        	<div class="row">

						        	<!-- con-sm-6 -->
						        	<div class="col-lg-6 col-sm-6 col-xs-6 col-md-6" style="padding-bottom:20px;">
							    			<div class="" style="position: relative;" data-toggle="modal" data-target="#myModal">
								    				<img class="img-responsive" src="{{url('images/upload/food/1.jpg')}}">
								    				<div class="bg_img" style="color:#f2e191;">
								    					<div class="pull-left">
								    						<span>{!!$product->name_en!!}</span><br>
								    						<span​​ style="font-size:11px;">{!!$product->name_kh!!}</span>
								    					</div>

								    					<div class="pull-right"><span style="color:#f2e191;">${!!$product->price!!}.00</span></div>
								    					<div class="clearfix"></div>
								    				</div>
							    			</div>
						    			</div>

						    			<!-- con-sm-6 -->
						        	<div class="col-lg-6 col-sm-6 col-xs-6 col-md-6" style="padding-bottom:20px;">
							    			<div class="" style="position: relative;" data-toggle="modal" data-target="#myModal">
								    				<img class="img-responsive" src="{{url('images/upload/food/1.jpg')}}">
								    				<div class="bg_img" style="color:#f2e191;">
								    					<div class="pull-left">
								    						<span>{!!$product->name_en!!}</span><br>
								    						<span​​ style="font-size:11px;">{!!$product->name_kh!!}</span>
								    					</div>

								    					<div class="pull-right"><span style="color:#f2e191;">${!!$product->price!!}.00</span></div>
								    					<div class="clearfix"></div>
								    				</div>
							    			</div>
						    			</div>

					        	</div>
					        	<div class="clearfix"></div>
					          <p>I love the deliciousness of certain words—the way something as ordinary as chocolate can take on an entire new personality when dressed up with adjectives like warm, rich, thick, gooey, chilled, creamy, or frothy. </p>

					        </div>
					        <!-- <div class="modal-footer">
					          <button type="button" class="btn btn-default" data-dismiss="modal" style="color:#f2e191;background-color:#000;color: white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); ">	 
					             Close
					          </button>
					        </div> -->
					      </div>
					    </div>
					   </div>
						 <!-- end Modal -->

					</div>
    			</div>
    		</div>
    		



    		<!-- ############### -->
    		<!-- <section class="regular slider">
			    <div>
			      <img src="http://placehold.it/350x300?text=1">
			    </div>
			    <div>
			      <img src="http://placehold.it/350x300?text=2">
			    </div>
			    <div>
			      <img src="http://placehold.it/350x300?text=3">
			    </div>
			    <div>
			      <img src="http://placehold.it/350x300?text=4">
			    </div>
			    <div>
			      <img src="http://placehold.it/350x300?text=5">
			    </div>
			    <div>
			      <img src="http://placehold.it/350x300?text=6">
			    </div>
			  </section> -->
    	</div>

    	<div class="container-fluid">
    		<div class="col-sm-3">
    			&nbsp;
    		</div>
    		<div class="col-sm-9">
		    	<footer style="border-top:1px solid #999;color:#999;border-radius: 6px;padding:10px 0;font-size:12px;width:100%;">
		    		<center>Copyright. All Right Reserved. Powered By: MQ</center>
		    	</footer>
    		</div>
    	</div>
    </body>
    </html>

	<!-- Scripts -->
	<script type="text/javascript" src="{{url('js/jquery-1.9.1.min.js')}}"></script>
	<script type="text/javascript" src="{{url('js/bootstrap.min.js')}}"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="{{url('lib/plugins/js/html5shiv.min.js')}}"></script>
        <script src="{{url('lib/plugins/js/respond.min.js')}}"></script>
	<![endif]-->

	<!-- carousel -->
	<script type="text/javascript" src="{{url('carousel/slick.js')}}"></script>
	<script type="text/javascript">
	    $(document).on('ready', function() {
	      $(".regular").slick({
	        dots: true,
	        infinite: true,
	        slidesToShow: 3,
	        slidesToScroll: 3
	      });
	      $(".center").slick({
	        dots: true,
	        infinite: true,
	        centerMode: true,
	        slidesToShow: 3,
	        slidesToScroll: 3
	      });
	      $(".variable").slick({
	        dots: true,
	        infinite: true,
	        variableWidth: true
	      });
	    });
	  </script>

	  <!-- script action -->
	  <script type="text/javascript">
	  	function initCat(pc_id){
	  		$.ajax({
          url: "{{url('product/getPCCategory')}}",
          dataType: "json",
          timeout: 3000,
          data: {
            pc_id:pc_id,
          },
          error: function(x, t, m) {
            if(t==="timeout") {
              // alert("got timeout");
            } else {
              // alert(t);
            }
            $(window).unbind('beforeunload');
            // location.reload();
            // window.location =  "{{url('/counter')}}";
          },
          success: function( data ) {
          	var html = '';
          	var html_product = '';

          	$.each(data, function(data_label, data_val){
          		$.each(data_val['sub_cat_product'], function(data_label, data_value){
	          		html += '<div class="col-lg-3 col-md-4 col-sm-3">';
	          			html += '<div class="sub-category-box">';
	          				html +='<a onclick="initSubCat('+data_value['psc_id']+');" href="javascript:void(0);"><i class="fa fa-wa fa-cutlery"></i> '+data_value['psc_name_en']+' / '+data_value['psc_name_kh']+'</a>';
	          				html += '</div>';
	    					html += '</div>';
	    				});
          	});

          	$("#product_subCat_html").html(html);
          	// ###########
          	$.each(data, function(data_label, data){
	          	$.each(data['product'], function(data_label, data_value){
	    					html_product +='<div class="col-lg-4 col-sm-6 col-xs-6 col-md-4" style="padding-bottom:20px;">';
				    			html_product +='<div class="" style="position: relative;" data-toggle="modal" data-target="#myModal">';
					    				html_product +='<img class="img-responsive" src="{{url("images/upload/food")}}/'+data_value['photo']+'">';
					    				html_product +='<div class="bg_img" style="color:#f2e191;">';
					    					html_product +='<div class="pull-left">';
					    						html_product +='<span>'+data_value['name_en']+'</span><br>';
					    						html_product +='<span​​ style="font-size:11px;">'+data_value['name_kh']+'</span>';
					    					html_product +='</div>';

					    					html_product +='<div class="pull-right"><span style="color:#f2e191;">'+data_value['price']+'</span></div>';
					    					html_product +='<div class="clearfix"></div>';
					    				html_product +='</div>';
				    			html_product +='</div>';
			    			html_product +='</div>';
	          	});
	          });

          	$("#sub_cat_food_html").html(html_product);
          }
      	});
	  	}
	  	// 
	  	function initSubCat(spc_id){
	  		$.ajax({
          url: "{{url('product/getSPCCategory')}}",
          dataType: "json",
          timeout: 3000,
          data: {
            spc_id:spc_id,
          },
          error: function(x, t, m) {
            if(t==="timeout") {
              // alert("got timeout");
            } else {
              // alert(t);
            }
            $(window).unbind('beforeunload');
            // location.reload();
            // window.location =  "{{url('/counter')}}";
          },
          success: function( data ) {
          	var html = '';
          	$.each(data, function(data_label, data_value){
	    					html +='<div class="col-lg-4 col-sm-6 col-xs-6 col-md-4" style="padding-bottom:20px;">';
				    			html +='<div class="" style="position: relative;" data-toggle="modal" data-target="#myModal">';
					    				html +='<img class="img-responsive" src="{{url("images/upload/food")}}/'+data_value['photo']+'">';
					    				html +='<div class="bg_img" style="color:#f2e191;">';
					    					html +='<div class="pull-left">';
					    						html +='<span>'+data_value['name_en']+'</span><br>';
					    						html +='<span​​ style="font-size:11px;">'+data_value['name_kh']+'</span>';
					    					html +='</div>';

					    					html +='<div class="pull-right"><span style="color:#f2e191;">$ '+data_value['price']+'.00</span></div>';
					    					html +='<div class="clearfix"></div>';
					    				html +='</div>';
				    			html +='</div>';
			    			html +='</div>';
          	});

          	$("#sub_cat_food_html").html(html);
          }
      	});
	  	}
	  </script>
