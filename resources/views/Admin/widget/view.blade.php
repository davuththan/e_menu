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
              
              {!! Form::model($data,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.content.update',$data->id]]) !!}
              
                <div class="with-border box-header">
                 <h3 class="box-title">{{$view_title}} Form</h3>
                 <div class="pull-right">
                   <span>
                     <a class="btn btn-default" href ="{{url('admin/content')}}">
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
                        {!! Form::select('content_category_id',[null => 'Select Category'] +$category,null,['class'=>'form-control view_profile']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Image</label>                     
                      <div class="col-sm-4">     
                      
                        <div class="col col-lg-12">
                            <img src="{{ $data->image or 'No image' }}" alt="" width="120" height="100">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Ordering</label>
                      <div class="col-sm-4">
                        {!! Form::text('ordering',null,['class'=>'form-control view_profile','placeholder'=>'Ordering']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Is Active</label>
                      <div class="col-sm-4">
                        {!! Form::checkbox('is_active', null, true,['class'=>'form-control view_profile', 'style'=>'width:40px']) !!}
                      </div>
                    </div>

                    <!-- Tabs -->
                    <div id="tabs">
                      <ul>
                        @foreach ($languages as $lang) 
                          <li><a href="#{{$lang->name}}" data-ajax="false"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> {{$lang->name}}</a></li>
                        @endforeach
                      </ul>
                      @foreach ($languages as $lang) 
                      <div id="{{$lang->name}}">
                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> Menu Title <span class="validate_label_red">*</span></label>
                          <div class="col-sm-8">                            
                            {{$dataDes[$lang->id]['name']}}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> Description <span class="validate_label_red">*</span></label>
                          <div class="col-sm-8">
                            <?php echo html_entity_decode($dataDes[$lang->id]['description']);?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Keywords</label>
                          <div class="col-sm-8">
                            {{$dataDes[$lang->id]['meta_keywords']}}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-4 control-label"><img src="{{$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Description</label>
                          <div class="col-sm-8">
                            {{$dataDes[$lang->id]['meta_description']}}
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
@section('bottomscripts')
<script defer="" src="{{WWW_SUB_DOMAIN}}assets/backend/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

function openCustomRoxy2(){
  jQuery('#roxyCustomPanel2').dialog({modal:true, width:875,height:600});
}
function closeCustomRoxy2(){
  jQuery('#roxyCustomPanel2').dialog('close');
}
</script>
@endsection

<!-- @include('Admin.common.fancybox') -->
