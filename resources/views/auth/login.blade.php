@extends('auth.layout')

@section('content')
<div class="register-box">
    <div style="padding:10px 0;">
      <center><img width="200px" src="{{url("images/logo.png")}}"></center>
    </div>
    <!-- <div class="register-logo">
      <a href="../../index2.html"><b>Long</b> Room</a>
    </div> -->
		@include('auth.error')
      <div class="register-box-body">
        <p class="login-box-msg">Login</p>
        {!! Form::open(['url' => 'auth/login']) !!}
          <div class="form-group has-feedback">
             {!! Form::text('username',null,['class'=>'form-control','placeholder'=>'username']) !!}
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          
          <div class="form-group has-feedback">
            {!! Form::password('password', ['class'=>'form-control','placeholder' => 'password']) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
            </div><!-- /.col -->
          </div>
        {!! Form::close() !!}
      </div><!-- /.form-box -->

      <div style="color:#888 !important;padding-top:10px;"><center>
© 2016 {!!COMPANY!!}  . All Right Reserved.</center></div>
    </div><!-- /.register-box -->


@endsection