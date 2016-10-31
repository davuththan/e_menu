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
              {!! Form::model($data,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.fmgr.f_time.update',$data->id]]) !!}
                <div class="with-border box-header">
                 <h3 class="box-title">{!!$view_title!!} Form</h3>
                 <div class="pull-right">
                   <span>
                     <button class="btn btn-success" type="submit">
                        <i class="fa fa-wa fa-save"></i> Save 
                     </button> &nbsp;&nbsp; 
                     <a class="btn btn-default" href ="{{url('admin/fmgr/f_time')}}">
                        <i class="fa fa-wa fa-reply"></i> Back to List
                     </a> 
                   </span>
                  </div>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                
                 @include('Admin.common.error_input')
                  <div class="box-body">

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Time <span class="validate_error">*</span></label>
                        <div class="col-sm-4">
                          <!-- !! Form::text('time',null,['class'=>'form-control','placeholder'=>'Time']) !!} -->
                          <!-- time Picker -->
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <!-- <label>Time picker:</label> -->
                              <div class="input-group">
                                <!-- <input type="text" class="form-control timepicker"> -->
                                {!! Form::text('time',null,['class'=>'form-control timepicker','placeholder'=>'Time']) !!}
                                <div class="input-group-addon">
                                  <i class="fa fa-clock-o"></i>
                                </div>
                              </div><!-- /.input group -->
                            </div><!-- /.form group -->
                          </div>
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Is Active</label>
                        <div class="col-sm-4">
                          <input type="checkbox" name="is_active" <?php if($data->is_active==1) echo "checked=''";?> value="1" class="form-control" style="width:40px;">
                        </div>
                      </div>

                  </div><!-- /.box-body -->

              {!! Form::close() !!}
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

@endsection
