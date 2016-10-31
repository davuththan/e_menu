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
              
              {!! Form::model($config_group,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.setting.config_group.update',$config_group->id]]) !!}
              
              	<div class="with-border box-header">
	               <h3 class="box-title">{{$view_title}} Form</h3>
	               <div class="pull-right">
		               <span>
			               <button class="btn btn-success" type="submit">
			               		<i class="fa fa-wa fa-save"></i> Save 
			               </button> &nbsp;&nbsp; 
			               <a class="btn btn-default" href ="{{url('admin/setting/config_group')}}">
				               	<i class="fa fa-wa fa-reply"></i> Back to List
			               </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              <!-- form start -->
                
                 @include('Admin.common.error_input')
                <div class="box-body">

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Name<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name']) !!}
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
  
  <script src="{{url('/js/ui/jquery-ui.js')}}"></script>
<script>
  $( "#tabs" ).tabs();
</script>  
  
@endsection