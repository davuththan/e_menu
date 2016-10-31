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
                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Origin <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('origin_id',[NULL => 'Select Origin'] +$origin,null,['class'=>'form-control','id'=>'origin_id']) !!}
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Destination <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('destination_id',[NULL => 'Select Destination'] +$destination,null,['class'=>'form-control','id'=>'destination_id']) !!}
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Flight Type <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('flight_type_id',[NULL => 'Select Type'] +$flightType,null,['class'=>'form-control','id'=>'flight_type_id']) !!}
                        </div>
                      </div>

                      <!-- form-name -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Flight Number <span class="validate_error">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('flight_number_id',[NULL => 'Select Number'] +$flightNumber,null,['class'=>'form-control','id'=>'flight_number_id']) !!}
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

<script src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery-ui.js"></script>
<script>
  $( "#tabs" ).tabs();
</script> 
  
@endsection

  @section('bottomscripts')
  <script defer="" src="{{WWW_SUB_DOMAIN}}assets/backend/ckeditor/ckeditor.js"></script>

@endsection