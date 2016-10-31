@extends('Admin.common.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.section_header')

    <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
              
              {!! Form::model($data,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.content_category.update',$data->id]]) !!}
              
              	<div class="with-border box-header">
	               <h3 class="box-title">{{$view_title}} Form</h3>
	               <div class="pull-right">
		               <span>
			               <button class="btn btn-success" type="submit">
			               		<i class="fa fa-wa fa-save"></i> Save 
			               </button> &nbsp;&nbsp; 
			               <a class="btn btn-default" href ="{{url('admin/content_category')}}">
				               	<i class="fa fa-wa fa-reply"></i> Back to List
			               </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              <!-- form start -->
                
                 @include('Admin.common.error_input')
                <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Parents</label>
                      <div class="col-sm-4">
                        {!! Form::select('parent_id',[null => 'Select Parent'] +$parents,null,['class'=>'form-control']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Ordering</label>
                      <div class="col-sm-4">
                        {!! Form::text('ordering',null,['class'=>'form-control','placeholder'=>'Ordering']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Image</label>                     
                      <div class="col-sm-4">
                        <input type="text" id="txtSelectedFile" name="image" value="{{ $data->image or '' }}" onclick="openCustomRoxy2()" class='form-control' placeholder="Select an image">
                        <div id="roxyCustomPanel2" style="display: none;">
                          <iframe src="{{WWW_SUB_DOMAIN.SMART_SELECT_IMAGE_FILEMANAGER}}" style="width:100%;height:100%" frameborder="0"></iframe>
                        </div>
                      
                        <div class="col col-lg-6">
                            <img src="{{ $data->image or 'No image' }}" alt="" width="120" height="100">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Is Active</label>
                      <div class="col-sm-4">
                        {!! Form::checkbox('is_active', null, true,['class'=>'form-control', 'style'=>'width:40px']) !!}
                      </div>
                    </div>

                    <!-- Tabs -->
                    <div id="tabs">
                      <ul>
                        @foreach ($languages as $lang) 
                          <li><a href="#{{$lang->code}}" data-ajax="false"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> {{$lang->name}}</a></li>
                        @endforeach
                      </ul>
                      @foreach ($languages as $lang) 
                      <div id="{{$lang->code}}">
                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> Menu Title <span class="validate_label_red">*</span></label>
                          <div class="col-sm-8">
                            {!! Form::hidden('_language_id[]',$lang->id) !!}
                            {!! Form::text('name_'.$lang->id,$dataDes[$lang->id]['name'],['class'=>'form-control','placeholder'=>'Name']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Keywords</label>
                          <div class="col-sm-8">
                            {!! Form::textarea('meta_keywords[]',$dataDes[$lang->id]['meta_keywords'],['class'=>'form-control','placeholder'=>'Metha Keywords']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Description</label>
                          <div class="col-sm-8">
                            {!! Form::textarea('meta_description[]',$dataDes[$lang->id]['meta_description'],['class'=>'form-control','placeholder'=>'Metha Description']) !!}
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>

   

                   
                    
                    
                </div><!-- /.box-body -->
                
              {!! Form::close() !!}
            </form>
            </div><!-- /.box -->
          
          </div>
        </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  
<script src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery-ui.js"></script>
<script>
  $( "#tabs" ).tabs();
</script>  
@endsection
@include('Admin.common.fancybox')