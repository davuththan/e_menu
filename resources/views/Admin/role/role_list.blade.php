@extends('Admin.common.header')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Role
        <small>Role Listing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Role</a></li>
        <li class="active">Role Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Role Listing</h3>

             <!--<span class="box-title" style="float:left;">User Listing</span>-->
             <span class="box-title" style="float:right;"><button class="btn btn-block btn-primary" onclick="location.href ='{{url('/admin/user/add')}}';"><i class="fa fa-wa fa-plus"></i> Add New</button></span>
             
            </div><!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr> 
                    <th>No</th>
                    <th>Name</th>
                    <th>Date Added</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Admin</td>
                    <td>12.March,2015</td>
                    <td>12.March,2015</td>
                    <td>
                      <a class="btn btn-small"><i class="fa fa-pencil"></i> Edit</a>
                      <a class="btn btn-small"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                  </tr>

                  <tr>
                    <td>2</td>
                    <td>Editer</td>
                    <td>12.March,2015</td>
                    <td>12.March,2015</td>
                    <td>
                      <a class="btn btn-small"><i class="fa fa-pencil"></i> Edit</a>
                      <a class="btn btn-small"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                  </tr>
                
                </tbody>
                <!--<tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                </tfoot>-->
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

@endsection

