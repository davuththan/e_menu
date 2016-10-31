@extends('Admin.common.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <small>Permisison Form</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Permission </a></li>
          <li class="active">Group User Permission</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
             
              <!-- form start -->
              <!-- {!! Form::model($group_role,['method' => 'PATCH','class'=>'form-horizontal','url' => '/admin/group_role_update/1']) !!} -->
              <form action="{{url('admin/group_role_update')}}" method="post" enctype="multipart/data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="with-border box-header">
                 <h3 class="box-title">Group Permission</h3>
                 <div class="pull-right">
                    <span>
                      <button class="btn btn-success" type="post">
                        <i class="fa fa-wa fa-save"></i> Save 
                      </button> &nbsp;&nbsp; 
                      <a class="btn btn-default" href ="{{url('admin/user_mgr/group_role')}}">
                        <i class="fa fa-wa fa-reply"></i> Back to List
                      </a>
                       
                    </span>
                  </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                  <div class="sform-groudp">
                    <div style="padding-top:30px;">
                      <label class="col-sm-2 control-label" for="input-name">Permission Access</label>
                      <div class="col-sm-10">
                          <div class="well well-sm" style="height: 500px; overflow: auto;">
                              <input type="hidden" name="id" value="<?php echo $group_role->id;?>">

                              <?php

                                $menu_arr='';
                                $menu_id_arr='';
                                $menu_parent_id_arr='';
                                
                                $group_id = $group_role->id;
                                $menu = DB::table('group_role_detail')
                                        ->where('group_role_id','=',$group_id)
                                        ->get();
                                
                                foreach ($menu as $key => $value) {
                                    $menu_arr .= $value->menu_code.":";
                                    $menu_id_arr .= $value->menu_id.":";
                                    $menu_parent_id_arr .= $value->parent_menu_id.":";
                                   
                                }
                                    
                                $menu_sep = explode(':',$menu_arr);
                                $menu_id_sep = explode(':',$menu_id_arr);
                                $menu_parent_id_sep = explode(':',$menu_parent_id_arr);
                                //print_r($menu_sep);

                                //table_menu
                                $menu = DB::table('menu')
                                        ->where('parent_id','=',0)
                                        ->orderBy('order_level','ASC')
                                        ->get();

                                
                                //foreach ($menu as $menus)
                                foreach ($menu as $key => $value) 
                                {
                                  $mm_id='';
                                  $mmcode='';
                                  $mparent_id='';
                                  $read='';
                                  $write='';

                                  $mtitle = $value->menu_name;
                                  $mcode = $value->menu_code;
                                  $mparent_id = $value->parent_id;
                                  
                                  //$m_menu_code = DB::table('group_role_detail')->where('group_role_id','=','1')->where('menu_code', $mcode)->pluck('menu_code');
                                  $mid = $value->id;

                                  if(in_array($mcode, $menu_sep)){
                                    $mm_id = $value->id;
                                    $mmcode = $value->menu_code;
                                    
                                    $read = DB::table('group_role_detail')->where('menu_code','=',$mcode)->where('group_role_id','=',$group_id)->pluck('read');
                                    $write = DB::table('group_role_detail')->where('menu_code','=',$mcode)->where('group_role_id','=',$group_id)->pluck('write');
                                    // echo'
                                    //   <input type="hidden" name="parent_menu_id[]" value="'.$mparent_id.'">
                                    //   <input type="hidden" name="menu_id[]" value="'.$mm_id.'">
                                    //   <input type="hidden" name="read[]" value="'.$read.'">
                                    //   <input type="hidden" name="write[]" value="'.$write.'">
                                    // ';
                                  }
                                ?>
                                  <div class="col-sm-12">
                                    <div class="col-sm-4">
                                      <div style="font-size:16px;font-weight:bold;padding-top:10px;">
                                        <input id="selecctall{{$mid}}" value="{{$mcode}}" <?php if(in_array($mcode, $menu_sep)){echo "checked='checked'";}?> name="menu_code[]" type="checkbox">&nbsp;&nbsp;{{$mtitle}}
                                        <p style="display:none;">
                                        <input class="chk_item{{$mid}}" type="checkbox" <?php if(in_array($mid, $menu_id_sep)){echo "checked='checked'";}?> value="{{$mid}}" name="menu_id[]" >
                                        <input class="chk_item{{$mid}}" type="checkbox" <?php if(in_array($mparent_id, $menu_parent_id_sep)){echo "checked='checked'";}?> value="{{$mparent_id}}" name="parent_menu_id[]" >
                                        </p>
                                      </div>
                                    </div>

                                    <div style="font-size:16px;font-weight:bold;padding-top:10px;" class="col-sm-4">
                                      <input class="chk_item{{$mid}}" id="selecctall_read{{$mid}}" type="checkbox" <?php if($read==1){echo'checked="checked"';}?> name="chk_read[]" value="{{$mcode}}"> Read
                                      <!-- <input class="chk_read{{$mid}}" id="selecctall_read{{$mid}}" type="checkbox" <?php //if($read==1){echo'checked="checked"';}?> name="chk_read[]" value="{{$mcode}}"> Read_2 -->
                                    </div>

                                    <div style="font-size:16px;font-weight:bold;padding-top:10px;" class="col-sm-4">
                                      <input class="chk_item{{$mid}}" id="selecctall_write{{$mid}}" type="checkbox" <?php if($write==1){echo'checked="checked"';}?> name="chk_write[]" value="{{$mcode}}"> Write
                                      <!-- <input class="chk_write{{$mid}}" id="selecctall_write{{$mid}}" type="checkbox" <?php //if($write==1){echo'checked="checked"';}?> name="chk_write[]" value="{{$mcode}}"> Write_2 -->
                                    </div>
                                  </div>
                                <?php
                                  //submenu
                                  $submenu = DB::table('menu')
                                  ->Where('parent_id', $mid)
                                  ->get();

                                  //foreach ($submenu as $submenus) {
                                  foreach ($submenu as $key => $value) {
                                    $s_id='';
                                    $s_code='';
                                    $sread='';
                                    $swrite='';
                                    $s_parent_id='';

                                    $sid = $value->id;
                                    $smtitle = $value->menu_name;
                                    $smcode = $value->menu_code;
                                    $sparent_id = $value->parent_id;
                                    //echo $dod = $m_smenu_code['main_menu_code'];
                                    //$m_smenu_code = DB::table('group_role_detail')->where('group_role_id','=','1')->where('menu_code', $smcode)->pluck('menu_code');
                                    
                                    if(in_array($smcode, $menu_sep)){
                                      $s_id = $value->id;
                                      $s_code = $value->menu_code;
                                      $s_parent_id = $value->parent_id;
                                      $sread = DB::table('group_role_detail')->where('menu_code','=',$s_code)->where('group_role_id','=',$group_id)->pluck('read');
                                      $swrite = DB::table('group_role_detail')->where('menu_code','=',$s_code)->where('group_role_id','=',$group_id)->pluck('write');

                                    }

                                    echo'
                                      <div class="col-sm-12" style="padding-left:80px;"> 
                                        <div class="checkbox">
                                          <div class="col-sm-4">';
                                ?>
                                            <input id="chk_sub_menu{{$sid}}" class="chk_item{{$mid}}" value="{{$smcode}}" <?php if(in_array($smcode, $menu_sep)){echo "checked='checked'";}?> type="checkbox" name="menu_code[]"/> <?php echo $smtitle;?>
                                            <p style="display:none;">
                                              <input class="chk_sub_item{{$sid}} chk_item{{$mid}}" type="checkbox" <?php if(in_array($sid, $menu_id_sep)){echo "checked='checked'";}?> value="{{$sid}}" name="menu_id[]" >
                                              <input class="chk_sub_item{{$sid}} chk_item{{$mid}}" type="checkbox" <?php if(in_array($sparent_id, $menu_parent_id_sep)){echo "checked='checked'";}?> value="{{$sparent_id}}" name="parent_menu_id[]" >
                                            </p>
                                            <!-- <input type="hidden" value="{{$sid}}" name="menu_id[]" >
                                            <input type="hidden" value="{{$sparent_id}}" name="parent_menu_id[]" > -->
                                <?php
                                      echo'</div>';
                                ?>
                                            <div class="col-sm-4"><input class="chk_read_main{{$sid}} chk_item_read{{$mid}} chk_item{{$mid}}" type="checkbox" <?php if($sread==1){echo'checked="checked"';}?> name="chk_read[]" value="{{$smcode}}"></div>
                                            <!-- <p>
                                            <input type="checkbox" class="chk_read{{$sid}} chk_item_read{{$mid}}" value="{{$sid}}" name="menu_id[]" >read12
                                            </p> -->

                                            <div class="col-sm-4"><input class="chk_write_main{{$sid}} chk_item_write{{$mid}} chk_item{{$mid}}" type="checkbox" <?php if($swrite==1){echo'checked="checked"';}?> name="chk_write[]" value="{{$smcode}}"></div>
                                            <!-- <p>
                                            <input type="checkbox" class="chk_write{{$sid}} chk_item_write{{$mid}}" value="{{$sid}}" name="menu_id[]" >Write12
                                            </p> -->
                                            <!-- Hidden Data -->

                                            <script type="text/javascript">
                                                //chk_sub_menu
                                                $('#chk_sub_menu{{$sid}}').click(function(event) {  //on click
                                                  if(this.checked) { // check select status
                                                      $('.chk_sub_item{{$sid}}').each(function() { //loop through each checkbox
                                                          this.checked = true;  //select all checkboxes with class "checkbox1"              
                                                      });
                                                  }else{
                                                      $('.chk_sub_item{{$sid}}').each(function() { //loop through each checkbox
                                                          this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                                                      });        
                                                  }
                                                });

                                                //selecctall_read_subMain
                                                $('.chk_read_main{{$sid}}').click(function(event) {  //on click
                                                  if(this.checked) { // check select status
                                                      $('.chk_read{{$sid}}').each(function() { //loop through each checkbox
                                                          this.checked = true;  //select all checkboxes with class "checkbox1"              
                                                      });
                                                  }else{
                                                      $('.chk_read{{$sid}}').each(function() { //loop through each checkbox
                                                          this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                                                      });        
                                                  }
                                                });
                                                
                                                //selecctall_write_subMain
                                                $('.chk_write_main{{$sid}}').click(function(event) {  //on click
                                                  if(this.checked) { // check select status
                                                      $('.chk_write{{$sid}}').each(function() { //loop through each checkbox
                                                          this.checked = true;  //select all checkboxes with class "checkbox1"              
                                                      });
                                                  }else{
                                                      $('.chk_write{{$sid}}').each(function() { //loop through each checkbox
                                                          this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                                                      });        
                                                  }
                                                });
                                            </script>

                                <?php
                                      echo'</div>
                                        </div>
                                      ';
                                    }
                                ?>
                                    <!--check and un check form-->
                                  <script>
                                    $(document).ready(function() {
                                      //SELECT
                                      $('#selecctall{{$mid}}').click(function(event) {  //on click
                                        if(this.checked) { // check select status
                                            $('.chk_item{{$mid}}').each(function() { //loop through each checkbox
                                                this.checked = true;  //select all checkboxes with class "checkbox1"              
                                            });
                                        }else{
                                            $('.chk_item{{$mid}}').each(function() { //loop through each checkbox
                                                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                                            });        
                                        }
                                      });
                                      //selecctall_read
                                      $('#selecctall_read{{$mid}}').click(function(event) {  //on click
                                        if(this.checked) { // check select status
                                            $('.chk_item_read{{$mid}}').each(function() { //loop through each checkbox
                                                this.checked = true;  //select all checkboxes with class "checkbox1"              
                                            });
                                        }else{
                                            $('.chk_item_read{{$mid}}').each(function() { //loop through each checkbox
                                                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                                            });        
                                        }
                                      });

                                      //selecctall_write
                                      $('#selecctall_write{{$mid}}').click(function(event) {  //on click
                                        if(this.checked) { // check select status
                                            $('.chk_item_write{{$mid}}').each(function() { //loop through each checkbox
                                                this.checked = true;  //select all checkboxes with class "checkbox1"              
                                            });
                                        }else{
                                            $('.chk_item_write{{$mid}}').each(function() { //loop through each checkbox
                                                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                                            });        
                                        }
                                      });

                                    });
                                  </script>

                                <?php
                                  }
                                ?>
                          </div>
                        <a onclick="$(this).parent().find(':checkbox').prop('checked', true);">Check All</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">Uncheck All</a></div>
                    </div>
                  </div>   
                </div><!-- /.box-body -->
                
              <!-- {!! Form::close() !!} -->
              </form>
            </div><!-- /.box -->
          
          </div>
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
  
@endsection

