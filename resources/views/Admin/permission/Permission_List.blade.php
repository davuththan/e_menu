@extends('Admin.common.layout')

@section('content')
  


 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permission
        <small>User Permission</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permission</a></li>
        <li class="active">User Permission</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="with-border box-header">
             <h3 class="box-title">Permission Listing</h3>
             <div class="pull-right"><span><button class="btn btn-primary" onclick="location.href ='{{url('/admin/user/add')}}';"><i class="fa fa-wa fa-pencil"></i> Add New</button>&nbsp;&nbsp;<button class="btn btn-danger" onclick="location.href ='{{url('/admin/user/add')}}';"><i class="fa fa-wa fa-trash"></i> Trash</button></spa></div>
            </div><!-- /.box-header -->

            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Reason</th>
                  <th>Action</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  <td>
                    <a onclick="location.href ='{{url('/employee/position/show/1')}}';" class="btn btn-small"><i class="fa fa-pencil"></i> Set Permission</a>
                  </td>
                </tr>
                
                <tr>
                  <td>175</td>
                  <td>Mike Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-danger">Not Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                  <td>
                    <a onclick="location.href ='{{url('/admin/permission/setPermission')}}';" class="btn btn-small"><i class="fa fa-pencil"></i> Set Permission</a>
                  </td>
                </tr>

              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
      </div>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

@endsection

