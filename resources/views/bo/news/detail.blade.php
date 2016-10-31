@extends('bo.common.layout') 

@section('content')

<div class="box box-info">
	@include('common.error')
	 <!-- form start -->
	@if(isset($entity) )
		{!! Form::model($entity,['method' => 'PATCH','id'=>'form','class'=>'form-horizontal','files'=>true,'route'=>['admin.cmgr.news.update',$entity->id]]) !!}
  	@else
  		{!! Form::open(['url' => 'admin/cmgr/news','id'=>'form','class'=>'form-horizontal','files'=>true]) !!}
  	@endif
  <div class="box-header with-border">
   <button type="submit"  class="btn btn-info pull-left" validation-submit="Form">Save</button> &nbsp;
    <a href="{{url('admin/cmgr/news')}}" class="btn btn-default">List</a>
    <a href="{{url('admin/cmgr/news')}}" class="btn btn-default pull-right">Back</a>
  </div><!-- /.box-header -->
    <div class="box-body news">
      <div class="col-sm-9">
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Published Date:<span class="text-danger">*</span></label>
	        <div class="col-sm-8">
	          {!! Form::text('published_date',null,['class'=>'form-control datepicker']) !!}
	          
	        </div>
	      </div>
      </div>

      <div class="col-sm-12">
      	@include('bo.news.tab')
      </div>
      
    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-footer -->
  {!! Form::close() !!}
</div><!-- /.box -->
 <script>
  $( function() {
    $( ".datepicker" ).datepicker();
  } );
  </script>
<script type="text/javascript">
<!--
	
//-->
	$(function(){
		
		$("#show_image").click(function(){
			$("#image").change(function(event){
				var fileName = $(this).val().split('\\').pop();
				$("#image_url").val(fileName);
				image_preview.src = URL.createObjectURL(event.target.files[0]);
			});
			$("#image").click();
		});

		$("#form").validate(
				{ ignore: [] ,//validate all tab
					invalidHandler: function(form, validator){
			            var errors = validator.numberOfInvalids();
			            var message = (errors == 1) ? "There is 1 error." : "There are errors.";
			            $("#errors").html(message).show();
			        }
				} 
		);
		
	});
</script>

 
@endsection
