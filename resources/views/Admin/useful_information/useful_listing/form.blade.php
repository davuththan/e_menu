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
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('useful_information/useful_listing.useful_info_listing')!!}</a></li>
        <li><a href="#">{!!trans('useful_information/useful_listing.useful_info_listing')!!}</a></li>
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
                {!! Form::model($UsefulInfoListings,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.useful_information.useful_listing.update',$UsefulInfoListings->id]]) !!}
              @else
                {!! Form::open(['url' => 'admin/useful_information/useful_listing','files'=> true,'class'=>'form-horizontal']) !!}
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
                     <a class="btn btn-default" href ="{{url('admin/useful_information/useful_listing')}}">
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
                      <li><a href="#general" data-ajax="false">General</a></li>
                      <li><a href="#attribute" data-ajax="false">Attributes</a></li>
                    </ul>
                    <!-- tab general -->
                    <div id="general">
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_listing.name')!!} <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_listing.useful_info_category')!!}<span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                          {!! Form::select('useful_InfoCategory_id',[null => 'Select Category'] +$useful_info_category,null,['class'=>'form-control']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_listing.year')!!}</label>
                        <div class="col-sm-4">
                          <select name="year" class="form-control">
                            <?php 
                              $i=2000;
                              for ($i=2000; $i <=date('Y') ; $i++) { 
                            ?>
                                <option @if(isset($UsefulInfoListings)) @if($UsefulInfoListings->year==$i) {{"selected='selected'"}} @endif @endif value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php 
                              }
                            ?>
                            <!-- <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                            <option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option> -->
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_listing.url')!!}</label>
                        <div class="col-sm-4">
                          {!! Form::text('url',null,['class'=>'form-control','placeholder'=>'URL']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_listing.file')!!} (*.pdf,*.doc,*.pwf,...) Max Size(3MB)</label>
                        <div class="col-sm-4">
                          {!! Form::file('attach_file',null,['class'=>'form-control']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">&nbsp;</label>
                        <div class="col-sm-4">
                          <?php 
                          if(isset($UsefulInfoListings)){
                            if($UsefulInfoListings->attach_file!=''){
                        ?>
                              <?php
                                $filename = $UsefulInfoListings->attach_file;
                                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                if($ext=='jpg'||$ext=='JPG'||$ext=='JPEG'||$ext=='png'||$ext=='PNG'){
                                  echo'<img src="'.SITE_HTTP_URL.'images/icons/image.jpg" width="50">';
                                }else if($ext=='pdf'){
                                  echo'<img src="'.SITE_HTTP_URL.'images/icons/pdf.png" width="50">';

                                }else if($ext=='zip'||$ext=='rar'){
                                  echo'<img src="'.SITE_HTTP_URL.'images/icons/zip.png" width="50">';

                                }else if($ext=='xls'){
                                  echo'<img src="'.SITE_HTTP_URL.'images/icons/excel.png" width="50">';

                                }else if($ext=='docx'||$ext=='doc'){
                                  echo'<img src="'.SITE_HTTP_URL.'images/icons/word.png" width="50">';

                                }else{
                                  echo'<img src="'.SITE_HTTP_URL.'images/icons/folder.png" width="50">';

                                }
                              ?>
                        <?php } }?>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">{!!trans('useful_information/useful_listing.description')!!}</label>
                        <div class="col-sm-8">
                          {!! Form::textarea('description',null,['class'=>'form-control ckeditor','placeholder'=>'Description']) !!}
                        </div>
                      </div>
                    </div>
                    <!-- tab attribute -->
                    <div id="attribute  ">
                      <table id="attribute" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <td>{!!trans('useful_information/useful_listing.name')!!}</td>
                            <td>{!!trans('useful_information/useful_listing.file')!!}</td>
                            <td>{!!trans('useful_information/useful_listing.action')!!}</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $attribute_row = 0; ?>
                          @if(isset($usefuls_data))
                            @foreach($usefuls_data as $useful_data)
                              <tr id="attribute-row<?php echo $attribute_row; ?>">
                                <td><input value="<?php echo $useful_data->name;?>" class="form-control" placeholder="{!!trans('useful_information/useful_listing.name')!!}" type="text" name="attribute_data[<?php echo $attribute_row;?>][name]"></td>
                                <td>
                                  <input type="hidden" value="{{$useful_data->attach_file}}" name="attribute_data[<?php echo $attribute_row;?>][attach_file_hidden]">
                                  <input type="file" name="attribute_data[<?php echo $attribute_row;?>][attach_file]">

                                  <?php
                                    $filename_data = $useful_data->attach_file;
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
                                <td><button type="button" onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                              </tr>
                              <?php $attribute_row++;?>
                            @endforeach
                          @endif
                        </tbody>

                        <tfoot>
                          <tr>
                            <td colspan="2"></td>
                            <td><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="{!!trans('useful_information/useful_listing.add_attribute')!!}" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                          </tr>
                        </tfoot>

                      </table>
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

    <script type="text/javascript"><!--
      var attribute_row = <?php echo $attribute_row; ?>;

      function addAttribute() {
          html  = '<tr id="attribute-row' + attribute_row + '">';
            html += '  <td style="width: 20%;"><input type="text" name="attribute_data[' + attribute_row + '][name]" value="" placeholder="{!!trans("useful_information/useful_listing.name")!!}" class="form-control" /></td>';
            html += '  <td>';
              html += '<input type="hidden" name="attribute_data['+attribute_row+'][attach_file_hidden]"/>';
              html += '<input type="file" name="attribute_data['+attribute_row+'][attach_file]"/>';
            html += '  </td>';
            // html += '<td>';
            //   html += '<input type="text" name="attribute_data['+attribute_row+'][order_level]"/>';
            // html += '</td>';
            html += '  <td><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="{!!trans("useful_information/useful_listing.remove_attribute")!!}" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
          html += '</tr>';

        $('#attribute tbody').append(html);

        // attributeautocomplete(attribute_row);

        attribute_row++;
      }
    </script>

@endsection
<!-- @include('Admin.common.fancybox') -->
