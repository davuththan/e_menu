@extends('Admin.common.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permission!
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Role</a></li>
        <li class="active">Permission</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Permission not allow!</h3>
          <p>
            You are not allowed to process this page! Please contact administrator!
            Meanwhile, you may <a href="{{url('/admin')}}">return to dashboard</a> or try using the search form.
          </p>
          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">
              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
              </div>
            </div><!-- /.input-group -->
          </form>
        </div><!-- /.error-content -->
      </div><!-- /.error-page -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

