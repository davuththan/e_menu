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
							<label class="col-sm-3 control-label">Job Title <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="job_title[{{$lang->id}}]" value="{{$des->job_title}}" class="form-control" required="required"/>
							</div>
						</div>
						 <div class="form-group">
							<label class="col-sm-3 control-label">Position Available</label>
							<div class="col-sm-3">
								<input type="text" name="position_available[{{$lang->id}}]" value="{{$des->position_available}}" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Location</label>
							<div class="col-sm-6">
								<input type="text" name="location[{{$lang->id}}]" value="{{$des->location}}" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Description</label>
							<div class="col-sm-6">
								<textarea rows="6" style="max-width: 100%;" name="description[{{$lang->id}}]" class="form-control ckeditor">{{$des->description}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta Description</label>
							<div class="col-sm-6">
								<textarea rows="6" style="max-width: 100%;" name="meta_description[{{$lang->id}}]" class="form-control">{{$des->meta_description}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta Keywords</label>
							<div class="col-sm-6">
								<textarea rows="6" style="max-width: 100%;" name="meta_keywords[{{$lang->id}}]" class="form-control">{{ $des->meta_keywords}}</textarea>
							</div>
						</div> 
					@endif
				@endforeach
				
			@else
				<div class="form-group">
					<label class="col-sm-3 control-label">Job Title <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="job_title[{{$lang->id}}]" class="form-control" required="required"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Position Available <span class="text-danger">*</span></label>
					<div class="col-sm-3">
						<input type="text" name="position_available[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Location <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="location[{{$lang->id}}]"  class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Description</label>
					<div class="col-sm-6">
						<textarea name="description[{{$lang->id}}]"  class="form-control ckeditor"/></textarea> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Meta Description</label>
					<div class="col-sm-6">
						<textarea rows="6" style="max-width: 100%;" name="meta_description[{{$lang->id}}]"  class="form-control"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Meta Keywords</label>
					<div class="col-sm-6">
						<textarea rows="6" style="max-width: 100%;" name="meta_keywords[{{$lang->id}}]"  class="form-control"></textarea>
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
