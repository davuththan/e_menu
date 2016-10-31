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
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('information/committee.committee')!!}</a></li>
        <li><a href="#">{!!trans('information/committee.committee_name')!!}</a></li>
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
                {!! Form::model($Committees,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.information.committee.update',$Committees->id]]) !!}
              @else
                {!! Form::open(['url' => 'admin/information/committee','files'=> true,'class'=>'form-horizontal']) !!}
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
                     <a class="btn btn-default" href ="{{url('admin/information/committee')}}">
                        <i class="fa fa-wa fa-reply"></i> {!!trans('common.back_to_listing')!!} 
                     </a> 
                   </span>
                  </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 
                 @include('Admin.common.error_input')
                <div class="box-body">
                  
                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('information/committee.committee_name')!!} <span class="validate_label_red">*</span></label>
                    <div class="col-sm-4">
                      {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Partner Name']) !!}
                    </div>
                  </div>


                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('information/committee.order_level')!!}</label>
                    <div class="col-sm-4">
                      {!! Form::text('order_level',null,['class'=>'form-control','placeholder'=>'Order Level']) !!}
                    </div>
                  </div>


                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('information/committee.image')!!} <span class="validate_label_red">*</span> (170px x 130px)</label>
                    <div class="col-sm-4">
                      <div style="position:relative;">
                        <!--e-logo-->
                        <div class="e-logo">
                          @if(isset($Committees))
                            @if($Committees->image!='')
                              <img src="{{url('images/upload/committee')}}/{{$Committees->image}}" id="p" />
                            @else
                              <img src="{{url('images/no-image.png')}}" id="p" />
                            @endif
                          @else
                            <img src="{{url('images/no-image.png')}}" id="p" />
                          @endif
                          <a class="file"><span>{!!trans('information/committee.choose_image')!!}</span>
                          {!! Form::file('image',['id'=>'photo','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                          </a>
                        </div>
                        <!--#END e-logo-->
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('information/committee.position')!!} <span class="validate_label_red">*</span></label>
                    <div class="col-sm-4">
                      {!! Form::text('position',null,['class'=>'form-control','placeholder'=>'Position']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('information/committee.company')!!} </label>
                    <div class="col-sm-4">
                      {!! Form::text('company',null,['class'=>'form-control','placeholder'=>'Company']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('information/committee.contact')!!} </label>
                    <div class="col-sm-4">
                      {!! Form::text('contact',null,['class'=>'form-control','placeholder'=>'Contact']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">{!!trans('information/committee.email')!!} </label>
                    <div class="col-sm-4">
                      {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
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
