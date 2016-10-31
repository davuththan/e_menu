@extends('fo.common.layout') 

@section('content')
<div class="wrapper_our_service">
	<div class="row">
		@include('fo.common.map')
	</div>
	<div class="col-sm-12 text-center padding-bottom-sm padding-top-sm">
		<h1 class="title_our_service">CONTACT</h1>
		<div class="col-lg-12">
			<div class="line-row">
				<div class="hr">&nbsp;</div>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="our_service col-sm-12 padding-bottom-lg">	
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-4">
						<center>
							<i class="fa fa-home" style="font-size:70px;font-weight: 900;"></i>
							<span class="contact-address"><h2>Address</h2></span>
							<span class="address">
								<p>
									Street 1986, Sangkat Phnom Penh Thmei,Khan Sen Sok, Phnom Penh, Cambodia.
								</p>
							</span>
						</center>
					</div>
					<div class="col-lg-4">
						<center>
							<i class="fa fa-phone" style="font-size:70px;font-weight:900;"></i>
							<span class="contact-address"><h2>Telephone</h2></span>
							<span class="address">
								<phone>010 234 234</phone>/
								<phone>010 234 234</phone>/
								<phone>010 234 234</phone>/
							</span>

						</center>
					</div>
					<div class="col-lg-4">
						<center>
							<i class="fa fa-envelope" style="font-size:70px;font-weight:900;"></i>
							<span class="contact-address"><h2>E-mail</h2></span>
							<span class="address">
								<email>zacresource@gmail.com</email>
							</span>
						</center>
					</div>

				</div>
				<div class="clearfix"></div>
			</div>

			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<span class="contact-address"><h2>GET INTOUCH</h2></span>
						<span class="address">
							<p>
								And get the lastest information about our company news and offer
							</p>
						</span>
					</div>
					<div class="col-lg-12">
						<div class="row">
						  <form action="./contact.php" class="form-horizontal" role="form" id="contactForm" method="post" name="contactForm">
        					<div class="col-lg-4">
						        <div class="form-group">
					            <div class="col-sm-12">
					            	<input class="form-control  input-md" name="name" id="name" type="text" placeholder="Name">
					            </div>
						        </div>
        					</div>
        					<div class="col-lg-4">
						        <div class="form-group">
					            <div class="col-sm-12">
			                 	 <input class="form-control contact input-md" name="email" id="email" type="email" placeholder="E-mail">
					            </div>
						        </div>	
        					</div>
        					<div class="col-lg-4">
						        <div class="form-group">
					            <div class="col-sm-12">
			                 	 <input class="form-control contact input-md" name="email" id="email" type="email" placeholder="Subject">
					            </div>
						        </div>	
        					</div>
        					
        					<div class="col-lg-12">
						        <div class="form-group">
					          	<div class="col-sm-12">
				                  <textarea class="form-control input-md" rows="10" name="message" id="message" placeholder="Message" style="max-width: 100%;max-height: 100%;"></textarea>
					             </div>
						        </div>
        					</div>
        
					        <div class="control-group submit center">
					        	<div class="col-lg-6">
					           	<input class="btn btn-lg btn-primary" value="SUBMIT YOUR MESSAGE >>" type="submit">
					        	</div>
					        </div>
      				</form>
							
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>

		</div>
	</div>
</div>

	
@endsection
<style type="text/css">
	.contact-address{color: #d11a48}
	.address{color: black;font-weight:500;}
	.form-control .contact{
 		display:block;
 		width:100%;
 		height:34px;
 		padding:6px 12px;
 		font-size:14px;
 		line-height:1.42857143;
 		color:#555;
 		background-color:red;
 		background-image:none;
 		border:1px solid #ccc;
 		border-radius:4px;
 		-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
 		box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
 		-webkit-transition:border-color ease-in-out .15s,
 		-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
 	}
</style>