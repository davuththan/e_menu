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
              {!! Form::model($content,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.cmgr.content.update',$content->id]]) !!}
                <div class="with-border box-header">
                 <h3 class="box-title">{{$view_title}} Form</h3>
                 <div class="pull-right">
                   <span> 
                     <a class="btn btn-default" href ="{{url('admin/cmgr/content')}}">
                        <i class="fa fa-wa fa-reply"></i> Back to List
                     </a> 
                   </span>
                  </div>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                
                 @include('Admin.common.error_input')
                  <div class="box-body">

                      <div class="form-group">
                      <label  class="col-sm-4 control-label">Menu Type<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::select('menu_type_id',[Null => 'Select Menu Type'] +$menutype,null,['class'=>'form-control','id'=>'menu_type_id']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Page <span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        <select class="form-control" name="fmenu_id" id="fmenu_id">
                          <option value="">Select Page</option>
                          @foreach($page_menu as $key=>$value)
                          <option @if($fmenu_id==$value->fmenu_id) selected="selected" @endif value="{{$value->f_fmenu_id}}">{{$value->f_name}}</option>
                          @endforeach
                          <!-- <option value="1">data</option> -->
                        </select>
                      </div>
                    </div>


                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Is Active </label>
                        <div class="col-sm-4">
                          <!-- !! Form::checkbox('is_active', null, true,['class'=>'form-control', 'style'=>'width:40px']) !!} -->
                          <input type="checkbox" name="is_active" value="1" <?php if($content->is_active==1) {echo 'checked="checked"';} ?> class="form-control" style="width:40px;">
                        </div>
                      </div>
                      <!-- Tabs -->
                    <div id="tabs">
                      <ul>
                        @foreach ($languages as $lang) 
                          <li><a href="#{{$lang->code}}" data-ajax="false"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {{$lang->name}}</a></li>
                        @endforeach
                      </ul>
                      @foreach ($languages as $lang) 
                      <div id="{{$lang->code}}">
                        {!! Form::hidden('_language_id[]',$lang->id) !!}
                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Description</label>
                          <div class="col-sm-8">
                            {!! Form::textarea('description_'.$lang->id,$dataDes[$lang->id]['description'],['class'=>'form-control ckeditor','placeholder'=>'Description']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Keywords</label>
                          <div class="col-sm-8">
                            {!! Form::textarea('meta_keywords[]',$dataDes[$lang->id]['meta_keywords'],['class'=>'form-control','placeholder'=>'Metha Keywords']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Description</label>
                          <div class="col-sm-8">
                            {!! Form::textarea('meta_description[]',$dataDes[$lang->id]['meta_description'],['class'=>'form-control','placeholder'=>'Metha Description']) !!}
                          </div>
                        </div>
                        
                      </div>
                      @endforeach
                    </div>

                  </div><!-- /.box-body -->

              {!! Form::close() !!}
            </div><!-- /.box -->
          
          </div>
        </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@include('Admin.content.ajax_push')
<script src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery-ui.js"></script>

<script>
  $( "#tabs" ).tabs();
</script>

@endsection
@section('bottomscripts')
<script defer="" src="{{WWW_SUB_DOMAIN}}assets/backend/ckeditor/ckeditor.js"></script>

@endsection
