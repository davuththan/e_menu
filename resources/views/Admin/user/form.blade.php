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
              @if(!isset($user))
                {!! Form::open(['url' => 'admin/user_mgr/user','files'=> true,'class'=>'form-horizontal']) !!}
              @else
                {!! Form::model($user,['method' => 'PATCH','files'=> true,'class'=>'form-horizontal','route'=>['admin.user_mgr.user.update',$user->id]]) !!}
              @endif

              	<div class="with-border box-header">
	               <h3 class="box-title">{{$view_title}} Form</h3>
	               <div class="pull-right">
		               <span>
			               <button class="btn btn-success" type="submit">
			               		<i class="fa fa-wa fa-save"></i> Save 
			               </button> &nbsp;&nbsp; 
			               <a class="btn btn-default" href ="{{url('admin/user_mgr/user')}}">
				               	<i class="fa fa-wa fa-reply"></i> Back to List
			               </a> 
		               </span>
	               	</div>
	              </div><!-- /.box-header -->
	              <!-- form start -->
	              
	               @include('Admin.common.error_input')
                <div class="box-body">
                  

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Group<span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        {!! Form::select('group_id',[null => 'Select Group'] +$group_user,null,['class'=>'form-control']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Username <span class="validate_label_red">*</span></label>
                      <div class="col-sm-4">
                        	{!! Form::text('username',null,['class'=>'form-control','placeholder'=>'username']) !!}
                      </div>
                    </div>
                    

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Email</label>
                      <div class="col-sm-4">
                        	{!! Form::email('email',null,['class'=>'form-control']) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label  class="col-sm-4 control-label">Image</label>
                      <div class="col-sm-4">
                        <!-- <input type="file" name="image" id="image"> -->
                        <div style="position:relative;">
                          <!--e-logo-->
                          <div class="e-logo">
                            @if(isset($user))
                              <input type="hidden" value="{{$user->photo}}" name="photo_hidden">
                              @if($user->photo!='') 
                                <img src="{{url('/images/upload/user')}}/{{$user->photo}}" id="t" />
                              @else
                                <img src="{{url('/images/no_image.png')}}" id="t" />
                              @endif
                            @else
                              <img src="{{url('/images/no_image.png')}}" id="t" />
                            @endif
                            <a class="file"><span>Choose Image</span>
                            {!! Form::file('photo',['id'=>'image','accept'=>'image/x-png, image/gif, image/jpeg']) !!}
                            </a>

                            <input type="hidden" name="">
                          </div>
                          <!--#END e-logo-->
                        </div>
                      </div>
                    </div>


                     @if(isset($user))
                      <!--  -->
                      <center><p style="padding: 15px 0;">* If you don't want to update password just keep it blank.</p></center>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Password </label>
                        <div class="col-sm-4">
                            {!! Form::password('password',null,['class'=>'form-control','placeholder'=>'Password']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Confirm Password </label>
                        <div class="col-sm-4">
                            {!! Form::password('password_confirmation',null,['class'=>'form-control','placeholder'=>'Confirm Password']) !!}
                        </div>
                      </div>
                    @else
                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Password <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                            {!! Form::password('password',null,['class'=>'form-control','placeholder'=>'Password']) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-4 control-label">Confirm Password <span class="validate_label_red">*</span></label>
                        <div class="col-sm-4">
                            {!! Form::password('password_confirmation',null,['class'=>'form-control','placeholder'=>'Confirm Password']) !!}
                        </div>
                      </div>
                    @endif
                    
                    
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
