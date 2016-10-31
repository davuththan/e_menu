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
              
              {!! Form::model($data,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.setting.language.update',$data->id],'files'=>true]) !!}
              
              	<div class="with-border box-header">
	               <h3 class="box-title">{{$view_title}} Form</h3>
	               <div class="pull-right">
		               <span>
			               <button class="btn btn-success" type="submit">
			               		<i class="fa fa-wa fa-save"></i> Save 
			               </button> &nbsp;&nbsp; 
			               <a class="btn btn-default" href ="{{url('admin/setting/language')}}">
				               	<i class="fa fa-wa fa-reply"></i> Back to List
			               </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              <!-- form start -->
                
                 @include('Admin.common.error_input')
                <div class="box-body">
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Language Name <span class="validate_label_red">*</span></label>
                      <div class="col-sm-8">
                            {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Language Code <span class="validate_label_red">*</span></label>
                      <div class="col-sm-8">
                            {!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Language Code']) !!}
                      </div>
                    </div>

                    <!-- <div class="form-group">
                      <label  class="col-sm-4 control-label">Directory <span class="validate_label_red">*</span></label>
                      <div class="col-sm-8">
                            {!! Form::text('directory',null,['class'=>'form-control','placeholder'=>'Directory']) !!}
                      </div>
                    </div> -->
                    
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Image</label>                     
                      <div class="col-sm-4">
                        <input type="text" id="txtSelectedFile" name="image" style="border:1px solid #ccc;cursor:pointer;padding:4px;width:80%;" value="{{ $data->image or '' }}" onclick="openCustomRoxy2()" placeholder="Select an image" class='form-control'>
                        <div id="roxyCustomPanel2" style="display: none;">
                          <iframe src="{{WWW_SUB_DOMAIN.SMART_SELECT_IMAGE_FILEMANAGER}}" style="width:100%;height:100%" frameborder="0"></iframe>
                        </div>
                      
                        <div class="col col-lg-6">
                            <img src="{{ SITE_HTTP_URL.$data->image }}" alt="">
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Ordering</label>
                      <div class="col-sm-4">
                        {!! Form::text('ordering',null,['class'=>'form-control','placeholder'=>'Ordering']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Is Active</label>
                      <div class="col-sm-4">
                        {!! Form::checkbox('is_active', null, true,['class'=>'form-control', 'style'=>'width:40px']) !!}
                      </div>
                    </div>
                    
                </div><!-- /.box-body -->
                
              {!! Form::close() !!}
            </form>
            </div><!-- /.box -->
          
          </div>
        </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  
  
@endsection
@section('bottomscripts')
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
