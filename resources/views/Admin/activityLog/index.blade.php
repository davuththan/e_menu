@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Users
        <small>Activities Log</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Activities Log</a></li>
        <li class="active">User Activities</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">User Activities</h3>
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Activities</th>
                    <th>Logged Date</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $i = 1;?>
	                @foreach ($ActivityLog as $key => $value)
	                
	                  <tr>
	                  	<td><?php echo($i); ?></td>
	                    <td>{{$value->username}}</td>
	                    <td>{{$value->action}} <?php echo $menuname = DB::table('menu')->where('menu_code', $value->menu_code)->pluck('menu_name');?></td>
	                    <td>{{$value->created_at}}</td>
	                    
	                  </tr>
					         <?php $i++; ?>
	               @endforeach
                
                </tbody>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

@endsection

