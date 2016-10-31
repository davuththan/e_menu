@extends('Admin.common.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>{{SITE_NAME}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="{{SITE_HTTP_URL}}admin/setting/config"><span class="info-box-icon bg-red"><i class="fa fa-gears"></i></span></a>
            <div class="info-box-content">
              <span class="info-box-number">Configuration</span>
              <span class="info-box-text">Management</span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="{{SITE_HTTP_URL}}admin/menu_mgr/fmenu"><span class="info-box-icon bg-aqua"><i class="fa fa-bars"></i></span></a>
            <div class="info-box-content">
              <span class="info-box-number">Frontend Menu</span>
              <span class="info-box-text">Management
                
              </span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="{{SITE_HTTP_URL}}admin/user_mgr/user"><span class="info-box-icon bg-green"><i class="fa fa-wa fa-users"></i></span></a>
            <div class="info-box-content">
              <span class="info-box-number">Users</span>
              <span class="info-box-text">Management</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="{{SITE_HTTP_URL}}admin/cmgr/content"><span class="info-box-icon bg-yellow"><i class="fa fa-location-arrow"></i></span></a>
            <div class="info-box-content">
              <span class="info-box-number">Content</span>
              <span class="info-box-text">Management</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
      </div><!-- /.row -->

      <!-- Main row -->
      <div class="row">

        <div class="col-md-12">
          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Activities</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">

                @foreach ($ActivityLog as $key => $value)
                  
                  <li class="item" style="float:left">
                    <div class="product-img">
                      <img class="img-circle" src="{{url('images/upload/user')}}/{{$value->photo}}" alt="No Image">
                    </div>
                    <div class="product-info">
                      <a href="{{url('images/upload/user')}}/{{$value->user_id}}" class="product-title">{{$value->username}}</a>
                      <span class="product-description">
                        {{$value->action}} <?php echo $menuname = DB::table('menu')->where('menu_code', $value->menu_code)->pluck('menu_name');?>
                        <br/><small style="font-size:8pt;"><i class="fa fa-clock-o"></i> {{$value->created_at}}</small>
                      </span>
                    </div>
                  </li><!-- /.item -->

                @endforeach
               
              </ul>
            </div><!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="{{SITE_HTTP_URL}}admin/activity_log" class="uppercase">View All Activities</a>
            </div><!-- /.box-footer -->
          </div><!-- /.box -->
        </div><!-- /.col -->

      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

