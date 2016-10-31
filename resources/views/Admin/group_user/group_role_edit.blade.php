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
              
              {!! Form::model($group_role,['method' => 'PATCH','class'=>'form-horizontal','route'=>['admin.user_mgr.group_role.update',$group_role->id]]) !!}
              	<div class="with-border box-header">
	               <h3 class="box-title">{{$view_title}} Form</h3>
	               <div class="pull-right">
		               <span>
			               <button class="btn btn-success" type="submit">
			               		<i class="fa fa-wa fa-save"></i> Save 
			               </button> &nbsp;&nbsp; 
			               <a class="btn btn-default" href ="{{url('admin/user_mgr/group_role')}}">
				               	<i class="fa fa-wa fa-reply"></i> Back to List
			               </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              <!-- form start -->
	              
	               @include('Admin.common.error_input')
                <div class="box-body">
                  	
                  	
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Name<span class="validate_label_red">*</span></label>
                      <div class="col-sm-10">
                        	{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'username']) !!}
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Group<span class="validate_label_red">*</span></label>
                      <div class="col-sm-10">
                        {!! Form::select('group_id',[null => 'Select Group'] +$group_user,null,['class'=>'form-control']) !!}
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-2 control-label">Remark <span class="validate_label_red">*</span></label>
                      <div class="col-sm-10">
                        	{!! Form::textarea('remark',null,['class'=>'form-control','placeholder'=>'Remark']) !!}
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