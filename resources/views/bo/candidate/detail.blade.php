@extends('bo.common.layout') 

@section('content')

<div class="box box-info">
	@include('common.error')
	 <!-- form start -->
	@if( isset($entity) )
		{!! Form::model($entity,['method' => 'PATCH','id'=>'form','class'=>'form-horizontal','files'=>true,'route'=>['admin.cmgr.candidate.update',$entity->id]]) !!}
  	@else
  		{!! Form::open(['url' => 'admin/cmgr/candidate','id'=>'form','class'=>'form-horizontal','files'=>true]) !!}
  	@endif
  <div class="box-header with-border">
   <button type="submit"  class="btn btn-info pull-left" validation-submit="Form">Save</button> &nbsp;
    <a href="{{url('admin/cmgr/candidate')}}" class="btn btn-default">List</a>
    <a href="{{url('admin/cmgr/candidate')}}" class="btn btn-default pull-right">Back</a>
  </div><!-- /.box-header -->
    <div class="box-body">
     	<!-- Custom Tabs -->
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		{{--*/ $first = true /*--}}
		@foreach ($languages as $language)
			<li class="{{ $first ? 'active':''}}">
				<a href="#tab_{{$language->id}}" data-toggle="tab"><img alt="flag" src="{{url($language->image)}}"></a>
			</li>
			{{--*/ $first = false /*--}}
		@endforeach
	</ul>
	<div class="tab-content">
		{{--*/ $first = true /*--}}
		@foreach ($languages as $lang)	
		<div class="tab-pane {{ $first ? 'active':''}}" id="tab_{{$lang->id}}">
			{{--*/ $first = false /*--}}
			@if (isset($career_des))
				@foreach ($career_des as $des)
					@if ($lang->id == $des->language_id)
						<div class="form-group">
							<label class="col-sm-3 control-label">Name<span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="name[{{$lang->id}}]" value="{{$des->job_title}}" class="form-control" required="required"/>
							</div>
						</div>
						 <div class="form-group">
							<label class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
							<div class="col-sm-3">
								<input type="text" name="email[{{$lang->id}}]" value="{{$des->email}}" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Location <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="location[{{$lang->id}}]" value="{{$des->location}}" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Description <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="description[{{$lang->id}}]" value="{{$des->description}}" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta Description <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="meta_description[{{$lang->id}}]" value="{{$des->meta_description}}" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta Keywords <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="meta_keywords[{{$lang->id}}]" value="{{ $des->meta_keywords}}" class="form-control"/>
							</div>
						</div> 
					@endif
				@endforeach
				
			@else
				<div class="form-group">
					<label class="col-sm-3 control-label">Name<span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="job_title[{{$lang->id}}]" class="form-control" required="required"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">E-mail <span class="text-danger">*</span></label>
					<div class="col-sm-3">
						<input type="text" name="position_available[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Contact <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="location[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Attact File <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="description[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Address <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="meta_description[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Remark <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="meta_keywords[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
			@endif
		</div>
		<!-- /.tab-pane -->
		
		@endforeach			
					
	</div>
	<!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->

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
			        }
				} 
		);
		
	});
</script>

 
@endsection
