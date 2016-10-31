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
            <div class="box-header">
              <h3 class="box-title">Permission Listing</h3>
              <div class="box-tools">
                <div class="input-group" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div><!-- /.box-header -->

            @if (count($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/permission/store') }}">  
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body table-responsive no-padding">
                <input type="text" name="name" value="{{ old('name') }}">
                <input type="text" name="permission" value="{{ old('permission') }}">
                <input type="text" name="display_name" value="{{ old('display_name') }}">
                <table class="table table-hover">
                
                  <tr>
                    <th>Module</th>
                    <th>Read</th>
                    <th>Add</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Export</th>
                    <th>Import</th>
                  </tr>
                  
                  <tr>
                    <td>Home/Dashboard</td>
                      <td><input type="checkbox" value="{user/users}=>1" name="titles"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="order_levels"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                  </tr>

                  <tr>
                    <td>User/User</td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                      <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                  </tr>

                  <tr>
                    <td>Role/User Role</td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                  </tr>

                  <tr>
                    <td>Permission/Permission_List</td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                  </tr>

                  <tr>
                    <td>Permission/setPermission</td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" name="checkPermission[]"></td>
                    <td><input type="checkbox" value="{user/users}=>1" name="checkPermission[]"></td>
                  </tr>
                  
                </table>
              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-default">Back to List</button>
                <button type="submit" class="btn btn-info pull-right"><i class="fa fa-wa fa-save"></i> &nbsp;Submit</button>
              </div><!-- /.box-footer -->
            </form>
          </div><!-- /.box -->
        </div>
      </div>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

@endsection

