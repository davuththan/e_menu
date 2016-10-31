@extends('bo.common.layout') 

@section('content')

<div class="box box-info">
	@include('common.error')
	 <!-- form start -->
	@if( isset($entity) )
		{!! Form::model($entity,['method' => 'PATCH','id'=>'form','class'=>'form-horizontal','route'=>['admin.user_mgr.group_user.update',$entity->id]]) !!}
  	@else
  		{!! Form::open(['url' => 'admin/user_mgr/group_user','id'=>'form','class'=>'form-horizontal']) !!}
  	@endif
  <div class="box-header with-border">
   <button type="submit"  class="btn btn-info pull-left" validation-submit="Form">Save</button> &nbsp;
    <a href="{{url('admin/user_mgr/group_user')}}" class="btn btn-default">List</a>
    <a href="{{url('admin/user_mgr/group_user')}}" class="btn btn-default pull-right">Back</a>
  </div><!-- /.box-header -->
    <div class="box-body">
      <div class="col-sm-9">
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Name <span class="text-danger">*</span></label>
	        <div class="col-sm-8">
	          {!! Form::text('name',null,['class'=>'form-control','required'=>'required']) !!}
	        </div>
	      </div>
	      <div class="form-group">
	        <label class="col-sm-4 control-label">Remark</label>
	        <div class="col-sm-8">
	          {!! Form::text('remark',null,['class'=>'form-control']) !!}
	        </div>
	      </div>
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
