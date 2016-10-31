@extends('bo.common.layout') 

@section('content')

<div class="box box-info">
	@include('common.error')
	 <!-- form start -->
	@if( isset($entity) )
		{!! Form::model($entity,['method' => 'PATCH','id'=>'form','class'=>'form-horizontal','files'=>true,'route'=>['admin.user_mgr.user.update',$entity->id]]) !!}
  	@else
  		{!! Form::open(['url' => 'admin/user_mgr/user','id'=>'form','class'=>'form-horizontal','files'=>true]) !!}
  	@endif
  <div class="box-header with-border">
   <button type="submit"  class="btn btn-info pull-left" validation-submit="Form">Save</button> &nbsp;
    <a href="{{url('admin/user_mgr/user')}}" class="btn btn-default">List</a>
    <a href="{{url('admin/user_mgr/user')}}" class="btn btn-default pull-right">Back</a>
  </div><!-- /.box-header -->
  	@include('auth.error')
    <div class="box-body">
      <div class="col-sm-9">
	      	<div class="form-group">
	        	<label class="col-sm-4 control-label">Image</label>
		        <div class="col-sm-8">
		          <div class="input-group">
			          <span class="input-group-addon" id="show_image"><i class="fa fa-upload"></i></span>
			          @if( isset($entity) )
			          	{!! Form::text('image_url',$entity->image,['class'=>'form-control','id'=>'image_url','readonly'=>'readonly']) !!}
			          @else
			          	{!! Form::text('image_url',null,['class'=>'form-control','id'=>'image_url','readonly'=>'readonly']) !!}
			          @endif
			          {!! Form::file('photo',['class'=>'hidden','id'=>'image']) !!}
			      </div>
	        	</div>
	      	</div>
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Username <span class="text-danger">*</span></label>
	        <div class="col-sm-8">
	          {!! Form::text('username',null,['class'=>'form-control']) !!}
	        </div>
	      </div>
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Email </label>
	        <div class="col-sm-8">
	          {!! Form::text('email',null,['class'=>'form-control']) !!}
	        </div>
	      </div>
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Group</label>
	        <div class="col-sm-8">
	          {!! Form::select('group_id',array_merge([null => 'Select Group'] + $group_user),null,['class'=>'form-control']) !!}
	        </div>
	      </div>
	      @if(isset($entity)) 
		      <div class="form-group text-center">
		        <span class="text-danger">If you want to change password, please input new password</span>
		      </div>
	      @endif
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Password <span class="text-danger">*</span></label>
	        <div class="col-sm-8">
	          {!! Form::password('password',['class'=>'form-control','id'=>'password']) !!}
	        </div>
	      </div>
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Confirm Password<span class="text-danger">*</span></label>
	        <div class="col-sm-8">
	          {!! Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','equalto'=>'#password']) !!}
	        </div>
	      </div>
      </div>
      <div class="col-sm-2">
      	@if( isset($entity) )
      		<img id="image_preview" class="img-responsive" alt="image-preview" src="{{url('images/upload')}}/{{$entity->photo}}">
      	@else
      		<img id="image_preview" class="img-responsive" alt="image-preview" src="{{url('images/c1.png')}}">
      	@endif
      </div>
      
    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-footer -->
  {!! Form::close() !!}
</div><!-- /.box -->

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
			        },
			        
				} 
		); 
		
	});
</script>

 
@endsection