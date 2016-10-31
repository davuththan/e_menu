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
              {!! Form::model($data,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.fmgr.f_description.update',$data->id]]) !!}
                <div class="with-border box-header">
                 <h3 class="box-title">{!!$view_title!!} Form</h3>
                 <div class="pull-right">
                   <span>
                     <button class="btn btn-success" type="submit">
                        <i class="fa fa-wa fa-save"></i> Save 
                     </button> &nbsp;&nbsp; 
                     <a class="btn btn-default" href ="{{url('admin/fmgr/f_description')}}">
                        <i class="fa fa-wa fa-reply"></i> Back to List
                     </a> 
                   </span>
                  </div>
                </div>

                <!-- /.box-header -->

                 <!-- form start -->
                 @include('Admin.common.error_input')
                  <div class="box-body">

                      <!-- form-name -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Flight Number <span class="validate_error">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('flight_number_id',[NULL => 'Select Number'] +$flightNumber,null,['class'=>'form-control','id'=>'flight_number_id']) !!}
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Flight Type <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('flight_type_id',[NULL => 'Select Type'] +$flightType,null,['class'=>'form-control','id'=>'flight_type_id']) !!}
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Flight Date <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          <!-- !! Form::text('flight_date',null,['class'=>'date-picker1 form-control','id'=>'flight_date','placeholder'=>'Flight Date']) !!} -->
                          <!-- <input type="text" name="flight_date" id="flight_date" placeholder="Flight Date" class="date-picker1 form-control" value="<?php echo date('d-M-Y')?>"> -->
                          {!! Form::text('flight_date',null,['class'=>'date-picker1 form-control','id'=>'flight_date']) !!}
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Route <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('flight_route_id',[NULL => 'Select Type'] +$flightRoute,null,['class'=>'form-control','id'=>'flight_route_id']) !!}
                        </div>
                      </div>

                      

                      <!-- form-name -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Flight Time <span class="validate_error">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('flight_time_id',[NULL => 'Select Time'] +$flightTime,null,['class'=>'form-control','id'=>'flight_time_id']) !!}
                        </div>
                      </div>

                      <!-- form-name -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Remark </label>
                        <div class="col-sm-4">
                          {!! Form::textarea('remark',null,['class'=>'form-control','id'=>'remark']) !!}
                        </div>
                      </div>
                      <!-- is_active -->
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

<!-- Date Time -->
<link rel="stylesheet" href="http://awa-cambodia.com/AWA/public/css/datetimepicker/bootstrap-datetimepicker.min.css">
<script src="http://awa-cambodia.com/AWA/public/css/datetimepicker/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
 //Validate Date time
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('.date-picker').datepicker({ 
    format: 'dd-M-yyyy',
    autoclose: true,
    startDate: today 
    });

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('.date-picker1').datepicker({ 
    format: 'yyyy-mm-dd',
    autoclose: true,
    startDate: today 
    });    
</script>

<script src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery-ui.js"></script>


<script>
  $( "#tabs" ).tabs();
</script>

@endsection
@section('bottomscripts')
<script defer="" src="{{WWW_SUB_DOMAIN}}assets/backend/ckeditor/ckeditor.js"></script>

@endsection
