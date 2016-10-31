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
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('design/common.design')!!}</a></li>
        <li><a href="#">{!!trans('design/banner.banner_name')!!}</a></li>
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
                {!! Form::model($Banners,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.design.banner.update',$Banners->id]]) !!}
              @else
                {!! Form::open(['url' => 'admin/design/banner','files'=> true,'class'=>'form-horizontal']) !!}
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
                     <a class="btn btn-default" href ="{{url('admin/design/banner')}}">
                        <i class="fa fa-wa fa-reply"></i> {!!trans('common.back_to_listing')!!} 
                     </a> 
                   </span>
                  </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                 @include('Admin.common.error_input')
                <div class="box-body">
                  
                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('design/banner.banner_name')!!} <span class="validate_label_red">*</span></label>
                    <div class="col-sm-4">
                      {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Banner Name']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('design/banner.url')!!}</label>
                    <div class="col-sm-4">
                      {!! Form::text('url',null,['class'=>'form-control','placeholder'=>'URL']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('design/banner.order_level')!!}</label>
                    <div class="col-sm-4">
                      {!! Form::text('order_level',null,['class'=>'form-control','placeholder'=>'Order Level']) !!}
                    </div>
                  </div>


                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('design/banner.image')!!} <span class="validate_label_red">*</span> (1300px x 600px)</label>
                    <div class="col-sm-4">
                      <div style="position:relative;">
                        <!--e-logo-->
                        <div class="e-logo">
                          @if(isset($Banners))
                            @if($Banners->image!='')
                              <img src="{{url('images/upload/banner')}}/{{$Banners->image}}" id="p" />
                            @else
                              <img src="{{url('images/no-image.png')}}" id="p" />
                            @endif
                          @else
                            <img src="{{url('images/no-image.png')}}" id="p" />
                          @endif
                          <a class="file"><span>{!!trans('design/banner.choose_image')!!}</span>
                          {!! Form::file('image',['id'=>'photo','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                          </a>
                        </div>
                        <!--#END e-logo-->
                      </div>
                    </div>
                  </div>


                  <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('design/banner.is_active')!!}</label>
                      <div class="col-sm-4">
                        {!! Form::checkbox('is_active', null, true,['class'=>'form-control', 'style'=>'width:40px']) !!}
                      </div>
                    </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('design/banner.description')!!}</label>
                    <div class="col-sm-8">
                      {!! Form::textarea('description',null,['class'=>'form-control ckeditor','placeholder'=>'Description']) !!}
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
