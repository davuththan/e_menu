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
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('information/information.information')!!}</a></li>
        <li><a href="#">{!!trans('information/information.information')!!}</a></li>
        <li class="active">{{$action}}</li>
      </ol>
    </section>

    <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
              @if($action=='Edit' || $action=='View')
                {!! Form::model($Informations,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.information.update',$Informations->id]]) !!}
              @else
                {!! Form::open(['url' => 'admin/information','files'=> true,'class'=>'form-horizontal']) !!}
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
                     <a class="btn btn-default" href ="{{url('admin/information')}}">
                        <i class="fa fa-wa fa-reply"></i> {!!trans('common.back_to_listing')!!} 
                     </a> 
                   </span>
                  </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 
                 @include('Admin.common.error_input')
                <div class="box-body">
                  
                  <!-- Tabs -->
                  <div id="tabs">
                    <ul>
                      <?php $languages = Helpers::getLanguage();?>

                      @foreach ($languages as $lang) 
                        <li><a href="#{{$lang->code}}" data-ajax="false"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {{$lang->name}}</a></li>
                      @endforeach
                    </ul>
                    <?php 
                      $i=1;
                      $name='';
                      $description='';
                    ?>
                    @foreach ($languages as $lang) 
                      <?php
                        if(isset($data_arr)){
                          $name = $data_arr[$lang->id]['name'];
                          $description = $data_arr[$lang->id]['description'];
                        }
                      ?>
                    {!! Form::hidden('language_id[]',$lang->id) !!}
                    <div id="{{$lang->code}}">
                      <div class="form-group">
                        <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {!!trans('information/information.information')!!} <span class="validate_label_red">*</span></label>
                        <div class="col-sm-8">
                          {!! Form::text('name_'.$lang->id,$name,['class'=>'form-control ckeditor','placeholder'=>'Information Name']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Description </label>
                        <div class="col-sm-8">
                          {!! Form::textarea('description_'.$lang->id,$description,['class'=>'form-control ckeditor','placeholder'=>'Description']) !!}
                        </div>
                      </div>

                      <div class="clearfix"></div>
                    </div>
                    <?php $i++;?>
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

@endsection
<!-- @include('Admin.common.fancybox') -->
