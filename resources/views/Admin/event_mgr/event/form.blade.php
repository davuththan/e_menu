@extends('Admin.common.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
      <!-- content-header -->
      <section class="content-header">
        <h1>
          {!!$view_title!!}
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-home"></i> {!!trans('event_mgr/common.event_mgr')!!}</a></li>
          <li><a href="#">{!!trans('event_mgr/event.event_name')!!}</a></li>
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
                {!! Form::model($Events,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.event_mgr.event.update',$Events->id]]) !!}
              @else
                {!! Form::open(['url' => 'admin/event_mgr/event','files'=> true,'class'=>'form-horizontal']) !!}
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
                     <a class="btn btn-default" href ="{{url('admin/event_mgr/event')}}">
                        <i class="fa fa-wa fa-reply"></i> {!!trans('common.back_to_listing')!!} 
                     </a> 
                   </span>
                  </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                @include('Admin.common.error_input')
                <div class="box-body">
                  <?php $current_date =date('d-M-Y');?>
                  <!-- Tabs -->
                  <div id="tabs">

                    <!--  -->
                    <ul>
                      <li><a href="#general" data-ajax="false">General</a></li>
                      <li><a href="#link" data-ajax="false">Link</a></li>
                      <li><a href="#images" data-ajax="false">Images</a></li>
                      <li><a href="#attribute" data-ajax="false">Attributes</a></li>
                    </ul>

                    <!-- general -->
                    <div id="general">

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('event_mgr/event.event_category')!!} <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('event_category_id',[null => 'Select Category'] +$event_category,null,['class'=>'form-control']) !!}
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Event Sub Category <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          @if(isset($Events))
                            @if($sub_event_name=='' && $sub_event_id=='')
                              <input type="text" placeholder="Event Sub Category" class="form-control" name="event_sub_category" id="event_sub_category">
                              <input type="hidden" name="event_sub_category_id" id="event_sub_category_id">
                            @else
                              <input value="{{$sub_event_name}}" type="text" placeholder="Event Sub Category" class="form-control" name="event_sub_category" id="event_sub_category">
                              <input value="{{$sub_event_id}}" type="hidden" name="event_sub_category_id" id="event_sub_category_id">
                            @endif
                          @else
                            <input type="text" placeholder="Event Sub Category" class="form-control" name="event_sub_category" id="event_sub_category">
                            <input type="hidden" name="event_sub_category_id" id="event_sub_category_id">
                          @endif
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('event_mgr/event.event_start')!!} <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          <input placeholder="Event Start" type="text" @if(isset($Events)) value="{{Helpers::FormatDate($Events->event_start)}}" @endif class="date-picker1 form-control" name="event_start">
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('event_mgr/event.event_end')!!} <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          <!-- !! Form::text('event_end',null,['class'=>'date-picker1 form-control','placeholder'=>'Event End']) !!} -->
                          <input placeholder="Event End" type="text" @if(isset($Events)) value="{{Helpers::FormatDate($Events->event_end)}}" @endif class="date-picker1 form-control" name="event_end">
                        </div>
                      </div>

                      <!-- form-group -->
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('event_mgr/event.publish_date')!!} <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::text('publish_date',$current_date,['class'=>'date-picker1 form-control','placeholder'=>'Publish Date']) !!}
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_listing.file')!!} (*.pdf,*.doc,*.pwf,...) Max Size(3MB)</label>
                        <div class="col-sm-4">
                          {!! Form::file('attach_file',null,['class'=>'form-control']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('event_mgr/event.image')!!} <span class="validate_label_red">*</span> (337px x 221px)</label>
                        <div class="col-sm-4">
                          <div style="position:relative;">
                            <!--e-logo-->
                            <div class="e-logo">
                              @if(isset($Events))
                                @if($Events->image!='')
                                  <img src="{{url('images/upload/events')}}/{{$Events->image}}" id="p" />
                                @else
                                  <img src="{{url('images/no-image.png')}}" id="p" />
                                @endif
                              @else
                                <img src="{{url('images/no-image.png')}}" id="p" />
                              @endif
                              <a class="file"><span>{!!trans('event_mgr/event.choose_image')!!}</span>
                              {!! Form::file('image',['id'=>'photo','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                              </a>
                            </div>
                            <!--#END e-logo-->
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('event_mgr/event.is_active')!!}</label>
                        <div class="col-sm-4">
                          {!! Form::checkbox('is_active', null, true,['class'=>'form-control', 'style'=>'width:40px']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('event_mgr/event.is_event')!!}</label>
                        <div class="col-sm-4">
                          {!! Form::checkbox('is_event', null, false,['class'=>'form-control', 'style'=>'width:40px']) !!}
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>

                    <!-- link -->
                    <div id="link">

                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-category"><span data-toggle="tooltip" title="Help">Item Event Category</span></label>
                        <div class="col-sm-8">
                          <input type="text" name="category" value="" placeholder="Event Sub Category" id="input-category" class="form-control" />
                          <div id="event-sub-category" class="well well-sm" style="height: 150px; overflow: auto;">
                            @if(isset($Events))
                              <?php foreach ($events as $event) { ?>
                              <div id="event-sub-category<?php echo $event->event_id;?>"><i class="fa fa-minus-circle"></i> <?php echo $event->event_name;?>
                                <input type="hidden" name="data_event_category[]" value="<?php echo $event->event_id;?>" />
                              </div>
                              <?php } ?>
                            @endif
                          </div>
                        </div>
                      </div>

                    </div>

                    <!-- #END link -->
                    <div class="clearfix"></div>

                    <!-- images -->
                    <div id="images">
                      <table class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <td>{!!trans('useful_information/useful_listing.name')!!}</td>
                            <td>Image</td>
                            <td>Order Level</td>
                            <td>{!!trans('useful_information/useful_listing.action')!!}</td>
                          </tr>
                        </thead>

                        <tbody>
                          <?php $attribute_image_row = 0; ?>
                          @if(isset($data_images))
                            @foreach($data_images as $data_image)
                              <tr id="attribute-row-image<?php echo $attribute_image_row;?>">
                                <td valign="center" style="width: 20%;"><input type="text" value="<?php echo $data_image['name'];?>" name="attribute_image[<?php echo $attribute_image_row;?>][name]" value="" placeholder="{!!trans("useful_information/useful_listing.name")!!}" class="form-control" /></td>
                                <td>
                                <div style="position:relative;">
                                  <div class="e-logo">
                                    <?php
                                      if($data_image['image']!=''){
                                    ?>
                                      <img width="150px" src="{{url("images/upload/events")}}/<?php echo $data_image['image'];?>" id="p<?php echo $attribute_image_row;?>" />
                                    <?php 
                                      }else{
                                    ?>
                                      <img src="{{url("images/no-image.png")}}" id="p<?php echo $attribute_image_row;?>" />
                                    <?php
                                      }
                                    ?>
                                    <a class="file"><span>Image</span>
                                    <input id="photo<?php echo $attribute_image_row;?>" accept="image/x-png, image/gif, image/jpeg" name="attribute_image[<?php echo $attribute_image_row;?>][image]" type="file">
                                    </a>
                                    <input type="hidden" value="<?php echo $data_image['image'];?>" name="attribute_image[<?php echo $attribute_image_row;?>][image_hidden]">
                                  </div>
                                </div>
                                 
                              </td>
                              
                              <td>
                                <input placeholder="Order Level" type="text" class="form-control" value="<?php echo $data_image['order_level']?>" name="attribute_image[<?php echo $attribute_image_row;?>][order_level]"/>
                              </td>
                                <td><button type="button" onclick="$('#attribute-row-image<?php echo $attribute_image_row;?>').remove();" data-toggle="tooltip" title="Remove Image" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                            </tr>

                              <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#photo<?php echo $attribute_image_row;?>').on('change', function(ev) {
                                      var f = ev.target.files[0];
                                      var fr = new FileReader();
                                      
                                      fr.onload = function(ev2) {
                                        console.dir(ev2);
                                        $('#p<?php echo $attribute_image_row;?>').attr('src', ev2.target.result);
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
                            <td colspan="3"></td>
                            <td><button type="button" onclick="addImage();" data-toggle="tooltip" title="Add Image" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Image</button></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="clearfix"></div>
                    
                    <!-- attribute -->
                    <div id="attribute">
                      <table class="table table-striped table-bordered table-hover">

                        <thead>
                          <tr>
                            <td>{!!trans('useful_information/useful_listing.name')!!}</td>
                            <td>{!!trans('useful_information/useful_listing.file')!!} (*.pdf, *.doc, *.xls, etc,..)</td>
                            <td>{!!trans('useful_information/useful_listing.order_level')!!}</td>
                          </tr>
                        </thead>

                        <tbody>
                          <?php $attribute_row = 0; ?>
                          @if(isset($data_files))
                            @foreach($data_files as $data_file)
                              <tr id="attribute-row<?php echo $attribute_row; ?>">
                                <td>
                                  <input value="<?php echo $data_file['name'];?>" class="form-control" placeholder="{!!trans('useful_information/useful_listing.name')!!}" type="text" name="attribute_data[<?php echo $attribute_row;?>][name]">

                                </td>
                                <td>
                                  <input type="hidden" value="<?php echo $data_file['file'];?>" name="attribute_data[<?php echo $attribute_row;?>][attach_file_hidden]"><br>

                                  <input type="file" name="attribute_data[<?php echo $attribute_row;?>][attach_file]">

                                  <?php
                                    $filename_data = $data_file['file'];
                                    $ext = pathinfo($filename_data, PATHINFO_EXTENSION);
                                    if($ext=='jpg'||$ext=='JPG'||$ext=='JPEG'||$ext=='png'||$ext=='PNG'){
                                      echo'<img src="'.SITE_HTTP_URL.'images/icons/image.jpg" width="30">';
                                    }else if($ext=='pdf'){
                                      echo'<img src="'.SITE_HTTP_URL.'images/icons/pdf.png" width="30">';
                                    }else if($ext=='zip'||$ext=='rar'){
                                      echo'<img src="'.SITE_HTTP_URL.'images/icons/zip.png" width="30">';
                                    }else if($ext=='xls'){
                                      echo'<img src="'.SITE_HTTP_URL.'images/icons/excel.png" width="30">';
                                    }else if($ext=='docx'||$ext=='doc'){
                                      echo'<img src="'.SITE_HTTP_URL.'images/icons/word.png" width="30">';
                                    }else{
                                      echo'<img src="'.SITE_HTTP_URL.'images/icons/folder.png" width="30">';
                                    }
                                  ?>
                                </td>

                                <td>
                                  <input type="text" value="{{$data_file['order_level']}}" placeholder="Order Level" class="form-control" name="attribute_data[<?php echo $attribute_row;?>][order_level]"/>
                                </td>

                                <td><button type="button" onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                              </tr>
                              <?php $attribute_row++;?>
                            @endforeach
                          @endif
                        </tbody>

                        <tfoot>
                          <tr>
                            <td colspan="2"></td>
                            <td><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="{!!trans('useful_information/useful_listing.add_attribute')!!}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Attribute</button></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>

                    <div class="clearfix"></div>

                  </div>
                </div><!-- /.box-body -->

                <!-- /.box-body -->
                <div class="box-body">
                  <!-- Tabs -->
                  <div id="tabs_alt">
                    
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
                      $meta_keyword='';
                      $meta_description='';
                    ?>

                    @foreach ($languages as $lang) 
                     <?php
                        if(isset($data_arr)){
                          $name = $data_arr[$lang->id]['name'];
                          $description = $data_arr[$lang->id]['description'];
                          $meta_keyword = $data_arr[$lang->id]['meta_keyword'];
                          $meta_description = $data_arr[$lang->id]['meta_description'];
                        }
                     ?>

                    {!! Form::hidden('language_id[]',$lang->id) !!}
                      <div id="{{$lang->code}}">
                         <div class="form-group">
                           <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {!!trans('event_mgr/event.event_name')!!}</label>
                           <div class="col-sm-8">
                             {!! Form::text('name_'.$lang->id,$name,['class'=>'form-control','placeholder'=>'Event Name']) !!}
                           </div>
                         </div>

                         <div class="form-group">
                           <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {!!trans('event_mgr/event.description')!!} </label>
                           <div class="col-sm-8">
                             {!! Form::textarea('description_'.$lang->id,$description,['class'=>'form-control ckeditor','placeholder'=>'Description']) !!}
                           </div>
                         </div>


                         <div class="form-group">
                           <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {!!trans('event_mgr/event.meta_keyword')!!} </label>
                           <div class="col-sm-8">
                             {!! Form::textarea('meta_keyword_'.$lang->id,$meta_keyword,['class'=>'form-control','placeholder'=>'Meta Keyword']) !!}
                           </div>
                         </div>


                         <div class="form-group">
                           <label  class="col-sm-4 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> {!!trans('event_mgr/event.meta_description')!!} </label>
                           <div class="col-sm-8">
                             {!! Form::textarea('meta_description_'.$lang->id,$meta_description,['class'=>'form-control','placeholder'=>'Meta Description']) !!}
                           </div>
                         </div>

                         <div class="clearfix"></div>
                      </div>
                    <?php $i++;?>

                    @endforeach
                  </div>
                </div>
              {!! Form::close() !!}
            </form>
            </div><!-- /.box -->
          
          </div>
        </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <script type="text/javascript">
    // attribute_image_row
    var attribute_image_row = <?php echo $attribute_image_row;?>;
    // addImage
    function addImage() {
      var html = '';
      html += '<tr id="attribute-row-image'+ attribute_image_row +'">';
        html += '<td valign="center" style="width: 20%;"><input type="text" name="attribute_image[' + attribute_image_row + '][name]" value="" placeholder="{!!trans("useful_information/useful_listing.name")!!}" class="form-control" /></td>';
        html += '<td>';
          html += '<div style="position:relative;">';
            html += '<div class="e-logo">';
              html += '<img src="{{url("images/no-image.png")}}" id="p'+attribute_image_row+'" />';
              html += '<a class="file"><span>Image</span>';
              html += '<input id="photo'+attribute_image_row+'" accept="image/x-png, image/gif, image/jpeg" name="attribute_image['+attribute_image_row+'][image]" type="file">';
              html += '<input type="hidden" name="attribute_image['+attribute_image_row+'][image_hidden]">';
              html += '</a>';
            html += '</div>';
          html += '</div>';
        html += '</td>';
        
        html += '<td>';
          html += '<input type="text" placeholder="Order Level" class="form-control" name="attribute_image['+attribute_image_row+'][order_level]"/>';
        html += '</td>';

        html += '<td><button type="button" onclick="$(\'#attribute-row-image' + attribute_image_row + '\').remove();" data-toggle="tooltip" title="Remove Image" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

      html += '</tr>';

      $('#images tbody').append(html);
      $.eventallData(attribute_image_row);
      attribute_image_row++;
    }

    // attribute_row
    var attribute_row = <?php echo $attribute_row;?>;
    // addAttribute
    function addAttribute(){
      var html_data ='';
      html_data  += '<tr id="attribute-row' + attribute_row + '">';
        html_data += '  <td style="width: 20%;"><input type="text" name="attribute_data[' + attribute_row + '][name]" value="" placeholder="{!!trans("useful_information/useful_listing.name")!!}" class="form-control" /></td>';
        html_data += '  <td>';
          html_data += '<input type="file" name="attribute_data['+attribute_row+'][attach_file]"/>';
          html_data += '<input type="hidden" name="attribute_data['+attribute_row+'][attach_file_hidden]">';
        html_data += '  </td>';
        html_data += '<td>';
          html_data += '<input placeholder="Order Level" type="text" class="form-control" name="attribute_data['+attribute_row+'][order_level]"/>';
        html_data += '</td>';
        html_data += '  <td><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="{!!trans("useful_information/useful_listing.remove_attribute")!!}" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
      html_data += '</tr>';
      $('#attribute tbody').append(html_data);
      attribute_row ++;
    }

    // event all script #####
    $(function(){
      $.eventallData = function(attribute_row){
        $(document).ready(function() {
          $('#photo'+attribute_row+'').on('change', function(ev) {
            var f = ev.target.files[0];
            var fr = new FileReader();
            
            fr.onload = function(ev2) {
              console.dir(ev2);
              $('#p'+attribute_row+'').attr('src', ev2.target.result);
            };
            
            fr.readAsDataURL(f);
          });
        });
      }
    });
    // }

    // function auto complete
    (function($) {
      $.fn.autocomplete = function(option) {
        return this.each(function() {
          this.timer = null;
          this.items = new Array();

          $.extend(this, option);

          $(this).attr('autocomplete', 'off');

          // Focus
          $(this).on('focus', function() {
            this.request();
          });

          // Blur
          $(this).on('blur', function() {
            setTimeout(function(object) {
              object.hide();
            }, 200, this);
          });

          // Keydown
          $(this).on('keydown', function(event) {
            switch(event.keyCode) {
              case 27: // escape
                this.hide();
                break;
              default:
                this.request();
                break;
            }
          });

          // Click
          this.click = function(event) {
            event.preventDefault();

            value = $(event.target).parent().attr('data-value');

            if (value && this.items[value]) {
              this.select(this.items[value]);
            }
          }

          // Show
          this.show = function() {
            var pos = $(this).position();

            $(this).siblings('ul.dropdown-menu').css({
              top: pos.top + $(this).outerHeight(),
              left: pos.left
            });

            $(this).siblings('ul.dropdown-menu').show();
          }

          // Hide
          this.hide = function() {
            $(this).siblings('ul.dropdown-menu').hide();
          }

          // Request
          this.request = function() {
            clearTimeout(this.timer);

            this.timer = setTimeout(function(object) {
              object.source($(object).val(), $.proxy(object.response, object));
            }, 200, this);
          }

          // Response
          this.response = function(json) {
            html = '';

            if (json.length) {
              for (i = 0; i < json.length; i++) {
                this.items[json[i]['value']] = json[i];
              }

              for (i = 0; i < json.length; i++) {
                if (!json[i]['category']) {
                  html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                }
              }

              // Get all the ones with a categories
              var category = new Array();

              for (i = 0; i < json.length; i++) {
                if (json[i]['category']) {
                  if (!category[json[i]['category']]) {
                    category[json[i]['category']] = new Array();
                    category[json[i]['category']]['name'] = json[i]['category'];
                    category[json[i]['category']]['item'] = new Array();
                  }

                  category[json[i]['category']]['item'].push(json[i]);
                }
              }

              for (i in category) {
                html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

                for (j = 0; j < category[i]['item'].length; j++) {
                  html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
                }
              }
            }

            if (html) {
              this.show();
            } else {
              this.hide();
            }

            $(this).siblings('ul.dropdown-menu').html(html);
          }

          $(this).after('<ul class="dropdown-menu"></ul>');
          $(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

        });
      }
    })(window.jQuery);

    // Category
    $('input[name=\'category\']').autocomplete({
      'source': function(request, response) {
        // console.log(request);
        $.ajax({
          url: '{{url('')}}/admin/event_mgr/getSubEvent?filter_name=' +  encodeURIComponent(request),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              console.log(item);
              return {
                label: item['event_name'],
                value: item['event_id']
              }
            }));
          }
        });
      },
      'select': function(item) {
        $('input[name=\'category\']').val('');
        $('#event-sub-category' + item['value']).remove();
        $('#event-sub-category').append('<div id="event-sub-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="data_event_category[]" value="' + item['value'] + '" /></div>');
      }
    });

    $('#event-sub-category').delegate('.fa-minus-circle', 'click', function(){
      $(this).parent().remove();
    });

    // getEventSubCategory
    $('input[name=\'event_sub_category\']').autocomplete({
      'source': function(request, response) {
        // console.log(request);
        $.ajax({
          url: '{{url('')}}/admin/event_mgr/getDataSubEvent?filter_name=' +  encodeURIComponent(request),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              console.log(item);
              return {
                label: item['event_name'],
                value: item['event_id']
              }
            }));
          }
        });
      },
      'select': function(item) {
        $('input[name=\'event_sub_category\']').val(item['label']);
        $('#event_sub_category_id').val(item['value']);
        // $('#event-sub-category' + item['value']).remove();
        // $('#event-sub-category').append('<div id="event-sub-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="data_event_category[]" value="' + item['value'] + '" /></div>');
      }
    });

  </script>

@endsection
<!-- @include('Admin.common.fancybox') -->
