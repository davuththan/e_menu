@extends('Admin.common.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        {!!$view_title!!}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('useful_information/useful_category.useful_info_category')!!}</a></li>
        <li><a href="#">{!!trans('useful_information/useful_category.useful_info_category')!!}</a></li>
        <li class="active">{!!trans('common.listing')!!}</li>
      </ol>
    </section>

    <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
              @if($action=='Edit' || $action=='View')
                {!! Form::model($UsefulInfoCategorys,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.useful_information.useful_category.update',$UsefulInfoCategorys->id]]) !!}
              @else
                {!! Form::open(['url' => 'admin/useful_information/useful_category','files'=> true,'class'=>'form-horizontal']) !!}
              @endif

                <div class="with-border box-header">
                 <h3 class="box-title">{!!$view_title!!} <small>{{$action}}</small></h3>
                 <div class="pull-right">
                   <span>
                    @if($action=='Edit' || $action=='Create')
                     <button class="btn btn-success" type="submit">
                        <i class="fa fa-wa fa-save"></i> {!!trans('common.save')!!} 
                     </button> &nbsp;&nbsp; 
                     @endif
                     <a class="btn btn-default" href ="{{url('admin/useful_information/useful_category')}}">
                        <i class="fa fa-wa fa-reply"></i> {!!trans('common.back_to_listing')!!} 
                     </a> 
                   </span>
                  </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                 @include('Admin.common.error_input')
                <div class="box-body">
                  
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_category.useful_info_category')!!} <span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Useful Info Category']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_category.order_level')!!}</label>
                      <div class="col-sm-4">
                        {!! Form::text('order_level',null,['class'=>'form-control','placeholder'=>'Order Level']) !!}
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
<!-- @include('Admin.common.fancybox') -->
