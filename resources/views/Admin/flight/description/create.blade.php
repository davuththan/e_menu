@extends('Admin.common.layout')

@section('content')
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header)-->
    @include('Admin.common.message') 
    @include('Admin.common.section_header')

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
              
              {!! Form::open(['url' => 'admin/fmgr/f_description','class'=>'form-horizontal','id'=>'msform']) !!}
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
                          <input type="text" name="flight_date" id="flight_date" placeholder="Flight Date" class="date-picker1 form-control" value="<?php echo date('Y-m-d')?>">
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Route <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('flight_route_id',[NULL => 'Select Route'] +$flightRoute,null,['class'=>'form-control','id'=>'flight_route_id']) !!}

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

                      <!-- form-is-active -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Is Active</label>
                        <div class="col-sm-4">
                          <input type="checkbox" name="is_active" checked="" value="1" class="form-control" style="width:40px;">
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

<div class="col-sm-5">
  <div class="pull-right panel-dropdown-lg panel-dropdown-mobile select-style">
      <input style="color:#fff;" name="departure_date" id="departure_date" class="date-picker1 panel-date-text-mobile panel-date-text-lg btn btn-lg" value="09-Feb-2016" type="text" readonly="readonly">
  </div>
</div>

<!-- Date Time -->
<link rel="stylesheet" href="{{url('/assets/frontend/css/date_bootstrap/bootstrap-datetimepicker.min.css')}}">
<script src="{{url('/assets/frontend/js/date_bootstrap/bootstrap-datetimepicker.min.js')}}"></script>

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


<!-- JQuery UI -->
<script src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery-ui.js"></script>
<script>
  $( "#tabs" ).tabs();
</script> 
  
@endsection

  @section('bottomscripts')
  <script defer="" src="{{WWW_SUB_DOMAIN}}assets/backend/ckeditor/ckeditor.js"></script>

@endsection
