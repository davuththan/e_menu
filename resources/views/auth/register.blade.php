@extends('auth.layout')

@section('content')
<div class="register-box">
      <div class="register-logo">
        <a href="../../index2.html"><b>ZAC</b> RESOURCES</a>
      </div>
		@include('auth.error')
      <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>
        {!! Form::open(['url' => 'auth/register']) !!}
          <div class="form-group has-feedback">
             {!! Form::text('username',null,['class'=>'form-control','placeholder'=>'username']) !!}
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
             {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'email']) !!}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {!! Form::password('password', ['class'=>'form-control','placeholder' => 'password']) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {!! Form::password('password_confirmation', ['class'=>'form-control','placeholder' => 'confirm password']) !!}
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        {!! Form::close() !!}
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

@endsection