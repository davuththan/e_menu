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
              {!! Form::model($where_we_fly,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.cmgr.where_we_fly.update',$where_we_fly->id]]) !!}
                <div class="with-border box-header">
                 <h3 class="box-title">{!!$view_title!!} Form</h3>
                 <div class="pull-right">
                   <span>
                     <a class="btn btn-default" href ="{{url('admin/cmgr/where_we_fly')}}">
                        <i class="fa fa-wa fa-reply"></i> Back to List
                     </a> 
                   </span>
                  </div>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                
                 @include('Admin.common.error_input')
                  <div class="box-body">

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Image (Size: W 740px, H 740px)<span class="validate_error">*</span></label>
                        
                        <!-- col-sm-4 -->
                        <div class="col-sm-4">
                          <!-- <input type="file" name="image" id="image"> -->
                          <div style="position:relative;">
                            <!--e-logo-->
                            <div class="e-logo">
                              @if($where_we_fly->image!='')
                                <img src="{{url('/images/uploads/where_we_fly')}}/{{$where_we_fly->image}}" id="t" />
                                
                              @else
                                <img src="{{url('/images/img/no-image.png')}}" id="t" />
                              @endif
                              <a class="file"><span>Choose Image</span>
                              {!! Form::file('image',['id'=>'image','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                              </a>
                            </div><!--#END e-logo-->
                          </div>
                        </div>

                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Is Active</label>
                        <div class="col-sm-4">
                          <input type="checkbox" name="is_active" <?php if($where_we_fly->is_active==1) echo "checked=''";?> value="1" class="form-control" style="width:40px;">
                        </div>
                      </div>

                      <!-- Tabs -->
                      <div id="tabs">
                        <ul>
                          @foreach ($languages as $lang) 
                            <li><a href="#{{$lang->code}}" data-ajax="false"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {{$lang->name}}</a></li>
                          @endforeach
                        </ul>
                        @foreach ($languages as $lang) 
                        <div id="{{$lang->code}}">
                          {!! Form::hidden('_language_id[]',$lang->id) !!}

                          <div class="form-group">
                            <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Title</label>
                            <div class="col-sm-8">
                              {!! Form::text('title[]',$dataDes[$lang->id]['title'],['class'=>'form-control ckeditor','placeholder'=>'Title']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Description</label>
                            <div class="col-sm-8">
                              {!! Form::textarea('description_'.$lang->id,$dataDes[$lang->id]['description'],['class'=>'form-control ckeditor','placeholder'=>'Description']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Keywords</label>
                            <div class="col-sm-8">
                              {!! Form::textarea('meta_keywords[]',$dataDes[$lang->id]['meta_keywords'],['class'=>'form-control','placeholder'=>'Metha Keywords']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Description</label>
                            <div class="col-sm-8">
                              {!! Form::textarea('meta_description[]',$dataDes[$lang->id]['meta_description'],['class'=>'form-control','placeholder'=>'Metha Description']) !!}
                            </div>
                          </div>
                          
                        </div>
                        @endforeach
                      </div>

                  </div><!-- /.box-body -->

              {!! Form::close() !!}
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
