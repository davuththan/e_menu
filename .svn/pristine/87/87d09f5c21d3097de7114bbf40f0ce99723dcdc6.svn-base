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
			@if (isset($news_des))
				@foreach ($news_des as $des)
					@if ($lang->id == $des->language_id)
						<div class="form-group">
							<label class="col-sm-3 control-label">Name <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="name[{{$lang->id}}]" value="{{$des->name}}" class="form-control" required="required"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Description <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<textarea rows="6" style="max-width: 100%;" name="description[{{$lang->id}}]" class="form-control ckeditor">{{$des->description}}</textarea>

							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta Description <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<textarea rows="6" style="max-width: 100%;" name="meta_description[{{$lang->id}}]" class="form-control">{{$des->meta_description}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Meta Keywords <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<textarea rows="6" style="max-width: 100%;" name="meta_keywords[{{$lang->id}}]" class="form-control">{{ $des->meta_keywords}}</textarea>
							</div>
						</div> 
					@endif
				@endforeach
				
			@else
				<div class="form-group">
					<label class="col-sm-3 control-label">Name <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="name[{{$lang->id}}]" class="form-control" required="required"/>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Description <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<textarea name="description[{{$lang->id}}]"  class="form-control ckeditor"/></textarea> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Meta Description <span class="text-danger">*</span></label>
					<div class="col-sm-6">
						<textarea rows="6" style="max-width: 100%;" name="meta_description[{{$lang->id}}]"  class="form-control"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Meta Keywords <span class="text-danger">*</span></label>
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
