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
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('members/common.members')!!}</a></li>
        <li><a href="#">{!!trans('members/member.member')!!}</a></li>
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
                {!! Form::model($Members,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.members.member.update',$Members->id]]) !!}
              @else
                {!! Form::open(['url' => 'admin/members/member','files'=> true,'class'=>'form-horizontal']) !!}
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
                     <a class="btn btn-default" href ="{{url('admin/members/member')}}">
                        <i class="fa fa-wa fa-reply"></i> {!!trans('common.back_to_listing')!!} 
                     </a> 
                   </span>
                  </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                 @include('Admin.common.error_input')
                <div class="box-body">
                  
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.member')!!} <span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Member Name']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.image')!!} (170px x 130px)</label>
                      <div class="col-sm-4">
                        <div style="position:relative;">
                          <!--e-logo-->
                          <div class="e-logo">
                            @if(isset($Members))
                              @if($Members->image!='')
                                <img src="{{url('images/upload/members')}}/{{$Members->image}}" id="p" />
                              @else
                                <img src="{{url('images/no-image.png')}}" id="p" />
                              @endif
                            @else
                              <img src="{{url('images/no-image.png')}}" id="p" />
                            @endif
                            <a class="file"><span>{!!trans('design/partner.choose_image')!!}</span>
                            {!! Form::file('image',['id'=>'photo','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                            </a>
                          </div>
                          <!--#END e-logo-->
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.member_type')!!}<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::select('member_type_id',[null => 'Select Member Type'] +$member_type,null,['class'=>'form-control']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.business_type')!!}<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::select('business_type_id',[null => 'Select Business Type'] +$business_type,null,['class'=>'form-control']) !!}
                      </div>
                    </div>

                     <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.base_country')!!} <span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::select('base_country_id',[null => 'Select Base Country'] +$base_country,null,['class'=>'form-control']) !!}
                      </div>
                    </div>


                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.position')!!}<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::select('position_id',[null => 'Select Position'] +$position,null,['class'=>'form-control']) !!}
                      </div>
                    </div>
                    

                   
                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.company_representative')!!}</label>
                      <div class="col-sm-4">
                        {!! Form::text('company_representative',null,['class'=>'form-control','placeholder'=>'Company Representative']) !!}
                      </div>
                    </div>                    

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.website')!!} </label>
                      <div class="col-sm-4">
                        {!! Form::text('website',null,['class'=>'form-control','placeholder'=>'Website']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.phone')!!} </label>
                      <div class="col-sm-4">
                        {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>'Phone']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.email')!!} </label>`
                      <div class="col-sm-4">
                        {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.address')!!} </label>
                      <div class="col-sm-6">
                        {!! Form::text('address',null,['col'=>'3','row'=>'3','class'=>'form-control','placeholder'=>'Address']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.remark')!!} </label>
                      <div class="col-sm-6">
                        {!! Form::text('remark',null,['class'=>'form-control','placeholder'=>'Remark']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">{!!trans('members/member.description')!!} </label>
                      <div class="col-sm-8">
                        {!! Form::textarea('description',null,['class'=>'ckeditor form-control','placeholder'=>'Description']) !!}
                      </div>
                    </div>
                    
                </div><!-- /.box-body
                
              {!! Form::close() !!}
            </form>
            </div><!-- /.box -->
          
          </div>
        </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

@endsection
<!-- @include('Admin.common.fancybox') -->
