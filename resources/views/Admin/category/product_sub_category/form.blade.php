@extends('Admin.common.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    @include('Admin.common.section_header') 

    <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
            
              @if(!isset($product_sub_category))
                {!! Form::open(['url' => 'admin/category/product_sub_category','files'=> true,'class'=>'form-horizontal']) !!}
              @else
                {!! Form::model($product_sub_category,['method' => 'PATCH','class'=>'form-horizontal','files'=> true,'route'=>['admin.category.product_sub_category.update',$product_sub_category->id]]) !!}
              @endif

              	<div class="with-border box-header">
	               <h3 class="box-title">{!!$view_title!!} Form</h3>
	               <div class="pull-right">
		               <span>
			               <button class="btn btn-success" type="submit">
			               		<i class="fa fa-wa fa-save"></i> Save 
			               </button> &nbsp;&nbsp; 
			               <a class="btn btn-default" href ="{{url('admin/category/product_sub_category')}}">
				               	<i class="fa fa-wa fa-reply"></i> Back to List
			               </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              <!-- form start -->
	              
	               @include('Admin.common.error_input')
                <div class="box-body">
                  <div class="form-group">
                    <label  class="col-sm-4 control-label">Category <span class="validate_label_red">*</span></label>
                    <div class="col-sm-4">
                      {!! Form::select('pc_id',[null => '--Choose Category--'] +$product_category,null,['class'=>'form-control']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">Sub Category / English <span class="validate_label_red">*</span></label>
                    <div class="col-sm-4">
                      	{!!Form::text('name_en',null,['class'=>'form-control','placeholder'=>'Sub Category Name']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">Sub Category / Khmer <span class="validate_label_red">*</span></label>
                    <div class="col-sm-4">
                        {!!Form::text('name_kh',null,['class'=>'form-control','placeholder'=>'Sub Category Name']) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">Icon</label>
                    <div class="col-sm-4">
                      <!-- <input type="file" name="image" id="image"> -->
                      <div style="position:relative;">
                        <!--e-logo-->
                        <div class="e-logo">
                          @if(isset($product_sub_category))
                            <input type="hidden" value="{{$product_sub_category->icon}}" name="icon_hidden">
                            @if($product_sub_category->icon!='') 
                              <img width="50px" src="{{url('images/upload/icon')}}/{{$product_sub_category->icon}}" id="t" />
                            @else
                              <img width="50px" src="{{url('images/no_image.png')}}" id="t" />
                            @endif
                          @else
                            <img width="50px" src="{{url('images/no_image.png')}}" id="t" />
                          @endif
                          <a class="file"><span>Choose Icon</span>
                          {!! Form::file('icon',['id'=>'image','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                          </a>
                        </div>
                        <!--#END e-logo-->
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label  class="col-sm-4 control-label">Order Level</label>
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

<!--ajax_image-->
<script>
  $('#userfile').on('change', function(ev) {
      var f = ev.target.files[0];
    var fr = new FileReader();
    
    fr.onload = function(ev2) {
      console.dir(ev2);
      $('#l').attr('src', ev2.target.result);
    };
    fr.readAsDataURL(f);
  });
</script>   
@endsection
<!-- @include('Admin.common.fancybox') -->
