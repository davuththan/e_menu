@extends('Admin.common.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    @include('Admin.common.section_header')

    <script type="text/javascript">
        $(function(){
          var menu_parent = $("select[name='menu_type_id']");
          
          var isFirstLoad = true;
          $("#menu_type_id").change(function(){
            isFirstLoad = true; //to avoid expired message show again
               $.getdata();
          });//end origin select

           $.getdata = function(){
            //alert('testing');
            //$('.tab-content a[href="#' + "tab_home" + '"]').tab('show');
            //refreshDiv();
            $.ajax({
                    url: "{{url('/admin/menu_mgr/menuParent')}}",
                    dataType: "json",
                    timeout: 3000,
                    data: {
                      menu_parent: menu_parent.val(),
                    },
                    error: function(x, t, m) {
                        if(t==="timeout") {
                            alert("got timeout");
                        } else {
                            alert(t);
                        }
                    },
                    success: function( data ) {
                      //console.log(data);
                      console.log("load data");
                      if(data.length==0){
                        $("#loading").hide();
                        alert("The page you requested is not found!");
                        
                        $("#boxscroll").html("<h1 style='color:#fff;'><center>The page you requested is not found!</center></h1>");
                        return;
                      }
                      text = "";
                      text += "<option value=''>--Destination--</option>";
                      $.each(data,function(menu_parent_id,menu_parent){
                  
                      text += "<option value='" + menu_parent.id + "'>";
                      text +=   menu_parent.md_name
                      text += "</option>";
                      });
                      
                      $("#parent_id").html(text); 
                      //$.refreshSeat();
                      //checkAvailableBus();
                      //checkEndWorkshift(); 
                    }
               });
          }
        
        });
        //window onload
        $(function(){
          
          $(window).load(function(){
            // $.getdata();
            $.doTimer();
            //$.getRateReil();
            $.getDiscountRate($customer_type);
            if($.cookie("isLeave") != undefined){
              $("#leave_checkbox").prop("checked",true);
              $(".receiver_payment").show();
            }
          });
          
        });
    </script>  
 
    <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
              
              <!-- !! Form::open(['url' => 'admin/menu_mgr/fmenu','class'=>'form-horizontal']) !!} -->
              {!! Form::open(['url' => 'admin/menu_mgr/fmenu','files'=> true,'class'=>'form-horizontal']) !!}
              	<div class="with-border box-header">
	               <h3 class="box-title">{{$view_title}} Form</h3>
	               <div class="pull-right">
		               <span>
                    <button class="btn btn-success" type="submit">
                    	<i class="fa fa-wa fa-save"></i> Save 
                    </button> &nbsp;&nbsp; 
                    <a class="btn btn-default" href ="{{url('admin/menu_mgr/fmenu')}}">
                    	<i class="fa fa-wa fa-reply"></i> Back to List
                    </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              
	              @include('Admin.common.error_input')
                <div class="box-body">

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Menu Type<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::select('menu_type_id',[null => 'Select Menu Type'] +$menu_type,null,['class'=>'form-control','id'=>'menu_type_id']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Parents</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="parent_id" id="parent_id">
                          <option value="0">Select Parent Menu</option>
                        </select>
                        <!-- !! Form::select('parent_id',[null => 'Select Parent Menu'] +$parents,null,['class'=>'form-control']) !!} -->
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">URL</label>
                      <div class="col-sm-4">
                        {!! Form::text('url',null,['class'=>'form-control','placeholder'=>'Menu Link']) !!}
                      </div>
                    </div>

                    <!-- <div class="form-group">
                      <label  class="col-sm-4 control-label">Menu Link<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::text('menu_link',null,['class'=>'form-control','placeholder'=>'Menu Link']) !!}
                      </div>
                    </div> -->

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Ordering</label>
                      <div class="col-sm-4">
                        {!! Form::text('ordering',null,['class'=>'form-control','placeholder'=>'Ordering']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Attach File (*.pdf,*.doc,*.pwf,...) <br>Max Size({{MAX_FILE_SIZE}})</label>
                      <div class="col-sm-4">
                        {!! Form::file('attach_file',null,['class'=>'form-control']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Is Active</label>
                      <div class="col-sm-4">
                        {!! Form::checkbox('is_active', null, true,['class'=>'form-control', 'style'=>'width:40px']) !!}
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

                        <div class="form-group">
                          <label  class="col-sm-3 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Menu Title  </label>
                          <div class="col-sm-9">
                            {!! Form::hidden('fmenu_language_id[]',$lang->id) !!}
                            {!! Form::text('name_'.$lang->id,'Menu Name',['class'=>'form-control','placeholder'=>'Menu Title']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-3 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Description </label>
                          <div class="col-sm-9">
                            {!! Form::textarea('description_'.$lang->id,'Description',['class'=>'form-control ckeditor','placeholder'=>'Description']) !!}
                          </div>
                        </div>
                          
                        <div class="form-group">
                          <label  class="col-sm-3 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Keywords</label>
                          <div class="col-sm-9">
                            {!! Form::textarea('meta_keywords[]','Meta Keyword',['class'=>'form-control','placeholder'=>'Meta Keywords']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-3 control-label"><img src="{{SITE_HTTP_URL.$lang->image}}" height="20" alt="{{$lang->name}}" /> Meta Description</label>
                          <div class="col-sm-9">
                            {!! Form::textarea('meta_description[]','Meta Description',['class'=>'form-control','placeholder'=>'Meta Description']) !!}
                          </div>
                        </div>
                      </div>
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
  
  
<script src="{{WWW_SUB_DOMAIN}}assets/backend/js/jquery-ui.js"></script>
<script>
  $( "#tabs" ).tabs();
</script>  
@endsection