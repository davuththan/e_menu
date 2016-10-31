$(document).ready(function() {
	var url 	= $('#url').val();
	
	$('body').on( "click", "#black_overlay, #closebox, #close_content", function(event){close_box()});
	
	
	/*$('#banner').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#b').attr('src', ev2.target.result);
		};
		fr.readAsDataURL(f);
	});
	
	$('#userfile1').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#l_1').attr('src', ev2.target.result);
		};
		fr.readAsDataURL(f);
	});*/
	
	$('#userfile2').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#l_2').attr('src', ev2.target.result);
		};
		fr.readAsDataURL(f);
	});
	
	
	$('#thumbnail').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#t').attr('src', ev2.target.result);
		};
		
		fr.readAsDataURL(f);
	});
	
	$('#photo').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#p').attr('src', ev2.target.result);
		};
		
		fr.readAsDataURL(f);
	});

	$('#image').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#t').attr('src', ev2.target.result);
		};
		
		fr.readAsDataURL(f);
	});


	$('#image1').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#t1').attr('src', ev2.target.result);
		};
		
		fr.readAsDataURL(f);
	});

	$('#image2').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#t2').attr('src', ev2.target.result);
		};
		
		fr.readAsDataURL(f);
	});

	$('#image3').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#t3').attr('src', ev2.target.result);
		};
		
		fr.readAsDataURL(f);
	});

	$('#image4').on('change', function(ev) {
    	var f = ev.target.files[0];
		var fr = new FileReader();
		
		fr.onload = function(ev2) {
			console.dir(ev2);
			$('#t4').attr('src', ev2.target.result);
		};
		
		fr.readAsDataURL(f);
	});
		
		/*$.ajax({
			type: "POST",
			url: url + "employer/add_favorite",
			data: dataString
		});*/
});