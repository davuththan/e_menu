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
			@if (isset($category_des))
				@foreach ($category_des as $des)
					@if ($lang->id == $des->language_id)
						<div class="form-group">
							<label class="col-sm-3 control-label">Name <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="name[{{$lang->id}}]" value="{{$des->name}}" class="form-control"/>
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
					<label class="col-sm-3 control-label">Name <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="name[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Description <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="description[{{$lang->id}}]"  class="form-control ckeditor"/>
						<!-- {!! Form::textarea('description_'.$lang->id,null,['class'=>'form-control ckeditor','placeholder'=>'Description']) !!} -->
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Meta Description <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="meta_description[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Meta Keywords <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="textarea" name="meta_keywords[{{$lang->id}}]"  class="form-control ckeditor"/>

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
