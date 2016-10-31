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
              @if(!isset($product))
                {!! Form::open(['url' => 'admin/category/product','files'=> true,'class'=>'form-horizontal']) !!}
              @else
                {!! Form::model($product,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.category.product.update',$product->id]]) !!}
              @endif

              	<div class="with-border box-header">
	               <h3 class="box-title">{!!$view_title!!} Form</h3>
	               <div class="pull-right">
		               <span>
			               <button class="btn btn-success" type="submit">
			               		<i class="fa fa-wa fa-save"></i> Save 
			               </button> &nbsp;&nbsp; 
			               <a class="btn btn-default" href ="{{url('admin/category/product')}}">
				               	<i class="fa fa-wa fa-reply"></i> Back to List
			               </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              <!-- form start -->
	              
	               @include('Admin.common.error_input')
                <div class="box-body">

                  <!-- tab -->
                  <h2 class="page-header">AdminLTE Custom Tabs</h2>
                  <div class="row">
                    <div class="col-md-12">
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
                          <li><a href="#tab_2" data-toggle="tab">Image</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_1">
                            <div class="form-group">
                              <label  class="col-sm-4 control-label">Category Name <span class="validate_label_red">*</span></label>
                              <div class="col-sm-4">
                                {!! Form::select('pc_id',[null => '--Choose Category--'] +$product_category,null,['class'=>'form-control']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <label  class="col-sm-4 control-label">Sub Category <span class="validate_label_red">*</span></label>
                              <div class="col-sm-4">
                                {!! Form::select('spc_id',[null => '--Choose Sub Category--'] +$product_sub_category,null,['class'=>'form-control']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <label  class="col-sm-4 control-label">Product Name / En <span class="validate_label_red">*</span></label>
                              <div class="col-sm-4">
                                  {!! Form::text('name_en',null,['class'=>'form-control','placeholder'=>'Product Name / En']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <label  class="col-sm-4 control-label">Product Name / Kh <span class="validate_label_red">*</span></label>
                              <div class="col-sm-4">
                                  {!! Form::text('name_kh',null,['class'=>'form-control','placeholder'=>'Product Name / Kh']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <label  class="col-sm-4 control-label">Icon</label>
                              <div class="col-sm-4">
                                <!-- <input type="file" name="image" id="image"> -->
                                <div style="position:relative;">
                                  <!--e-logo-->
                                  <div class="e-logo">
                                    @if(isset($product))
                                      <input type="hidden" value="{{$product->icon}}" name="icon_hidden">
                                      @if($product->icon!='') 
                                        <img width="50px" src="{{url('images/upload/product')}}/{{$product->icon}}" id="t" />
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
                              <label  class="col-sm-4 control-label">Image</label>
                              <div class="col-sm-4">
                                <!-- <input type="file" name="image" id="image"> -->
                                <div style="position:relative;">
                                  <!--e-logo-->
                                  <div class="e-logo">
                                    @if(isset($product))
                                      <input type="hidden" value="{{$product->photo}}" name="photo_hidden">
                                      @if($product->photo!='') 
                                        <img width="150px" src="{{url('/images/upload/product')}}/{{$product->photo}}" id="p" />
                                      @else
                                        <img width="150px" src="{{url('/images/no_image.png')}}" id="p" />
                                      @endif
                                    @else
                                      <img width="150px" src="{{url('/images/no_image.png')}}" id="p" />
                                    @endif
                                    <a class="file"><span>Choose Image</span>
                                    {!! Form::file('photo',['id'=>'photo','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                                    </a>
                                  </div>
                                  <!--#END e-logo-->
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <label  class="col-sm-4 control-label">Price <span class="validate_label_red">*</span></label>
                              <div class="col-sm-4">
                                  {!! Form::text('price',null,['class'=>'form-control','placeholder'=>'Eg: 12']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <label  class="col-sm-4 control-label">Description </label>
                              <div class="col-sm-4">
                                  {!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Description']) !!}
                              </div>
                            </div>
                          </div><!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_2">
                            <table id="images_tbl" class="table table-bordered">
                              <thead>
                                <th>Image</th>
                                <th>Title / En</th>
                                <th>Title / Kh</th>
                                <th>Order Level</th>
                                <th>Action</th>
                              </thead>
                              <tbody>
                                <?php $attribute_image_row=0;?>
                                @if(isset($attribute_images))
                                  @foreach($attribute_images as $attribute_image)
                                    <tr id="attribute-row-image<?php echo $attribute_image_row;?>">
                                      <td>
                                        <!-- <input type="file" name="image" id="image"> -->
                                        <div style="position:relative;">
                                          <!--e-logo-->
                                          <div class="e-logo">
                                            @if($attribute_image->image!='')
                                              <img width="150px" src="{{url('images/upload')}}/product/{{$attribute_image->image}}" id="tt<?php echo $attribute_image_row;?>" />
                                            @else
                                              <img width="150px" src="{{url('images/no_image.png')}}" id="tt<?php echo $attribute_image_row;?>" />
                                            @endif
                                            <a class="file"><span>Choose Image</span>
                                              <input id="image<?php echo $attribute_image_row;?>" accept="image/x-png, image/gif, image/jpeg" name="attribute_image[<?php echo $attribute_image_row;?>][image]" type="file">
                                            </a>
                                          </div>
                                          <!--#END e-logo-->
                                        </div>
                                      </td>
                                      <td><input type="text" value="<?php echo $attribute_image->title_en;?>" placeholder="Title / En" class="form-control" name="attribute_image[<?php echo $attribute_image_row;?>][title_en]"></td>
                                      <td><input type="text" value="<?php echo $attribute_image->title_kh;?>" placeholder="Title / Kh" class="form-control" name="attribute_image[<?php echo $attribute_image_row;?>][title_kh]"></td>
                                      <td><input type="text" value="<?php echo $attribute_image->order_level;?>" placeholder="Order Level" class="form-control" name="attribute_image[<?php echo $attribute_image_row;?>][order_level]"></td>
                                      <td><button type="button" onclick="$('#attribute-row-image<?php echo $attribute_image_row;?>').remove();" class="btn btn-danger btn-sm"><i class="fa fa-wa fa-minus"></i></button></td>
                                    </tr>
                                    <input type="hidden" value="{{$attribute_image->image}}" name="attribute_image[<?php echo $attribute_image_row;?>][image_hidden]">

                                    <script type="text/javascript">
                                      $(document).ready(function() {
                                        $('#image<?php echo $attribute_image_row;?>').on('change', function(ev) {
                                          var f = ev.target.files[0];
                                          var fr = new FileReader();
                                          
                                          fr.onload = function(ev2) {
                                            console.dir(ev2);
                                            $('#tt<?php echo $attribute_image_row;?>').attr('src', ev2.target.result);
                                          };
                                          
                                          fr.readAsDataURL(f);
                                        });
                                      });
                                    </script>
                                    <?php $attribute_image_row++;?>
                                  @endforeach
                                @endif

                              </tbody>
                              <tfoot>
                                <tr>
                                  <td colspan="4">&nbsp;</td>
                                  <td><button onclick="addImage();" type="button" class="btn btn-primary"><i class="fa fa-wa fa-plus"></i></button></td>
                                </tr>
                              </tfoot>
                            </table>
                          </div><!-- /.tab-pane -->
                          
                        </div><!-- /.tab-content -->
                      </div><!-- nav-tabs-custom -->
                    </div><!-- /.col -->

                  </div> <!-- /.row -->
                  <!-- #END tab -->
                    
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


  // attribute_image_row
    var attribute_image_row = <?php echo $attribute_image_row;?>;
    // addImage
    function addImage() {
      var html = '';
      html += '<tr id="attribute-row-image'+ attribute_image_row +'">';
        html += '<td>';
          html += '<div style="position:relative;">';
            html += '<div class="e-logo">';
              html += '<img width="150px" src="{{url("images/no_image.png")}}" id="tt'+attribute_image_row+'" />';
              html += '<a class="file"><span>Image</span>';
              html += '<input id="thumb'+attribute_image_row+'" accept="image/x-png, image/gif, image/jpeg" name="attribute_image['+attribute_image_row+'][image]" type="file">';
              html += '<input type="hidden" name="attribute_image['+attribute_image_row+'][image_hidden]">';
              html += '</a>';
            html += '</div>';
          html += '</div>';
        html += '</td>';

        html += '<td valign="center" style="width: 20%;"><input type="text" name="attribute_image[' + attribute_image_row + '][title_en]" value="" placeholder="Title / En" class="form-control" /></td>';

        html += '<td valign="center" style="width: 20%;"><input type="text" name="attribute_image[' + attribute_image_row + '][title_kh]" value="" placeholder="Title / Kh" class="form-control" /></td>';
        
        html += '<td>';
          html += '<input type="text" placeholder="Order Level" class="form-control" name="attribute_image['+attribute_image_row+'][order_level]"/>';
        html += '</td>';

        html += '<td><button type="button" onclick="$(\'#attribute-row-image' + attribute_image_row + '\').remove();" data-toggle="tooltip" title="Remove Image" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

      html += '</tr>';

      $('#images_tbl tbody').append(html);
      $.eventallData(attribute_image_row);
      attribute_image_row++;
    }
  // event all script #####
  $(function(){
    $.eventallData = function(attribute_row){
      $(document).ready(function() {
        $('#thumb'+attribute_row+'').on('change', function(ev) {
          var f = ev.target.files[0];
          var fr = new FileReader();
          
          fr.onload = function(ev2) {
            console.dir(ev2);
            $('#tt'+attribute_row+'').attr('src', ev2.target.result);
          };
          
          fr.readAsDataURL(f);
        });
      });
    }
  });
  // }

</script>   
@endsection
<!-- @include('Admin.common.fancybox') -->
