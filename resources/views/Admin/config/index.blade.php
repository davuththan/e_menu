@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Config
        <small> Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Config Group</a></li>
        <li class="active">Config</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Config Listing</h3>
             <div class="pull-right">
             	<span>
             	</span>
             </div>
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                   
                    <th>Config Group</th>
                    <th>Name</th>
                    <th>Keywords</th>
                    <th>Value</th>
                    <th>Action</th>
                  </tr>
                </thead> 
                <tbody>
                	<?php $i = 1;?>
                  <?php   
                  //print_r($alldata); exit;               
	                foreach($alldata as $data){
	                ?>
	                  <tr>
	                  	<td width="50"><?php echo($i); ?></td>
	                   
	                    <td>{{ $data->cg_name }}</td>
                      <td>{{ $data->name}} </td>
	                    <td>{{ $data->keywords }}</td>
                      <td>{{ substr($data->value,0,70) }}</td>
	                    
	                    <td width="250">
	                      <a href="{{route('admin.setting.config.edit',$data->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
	                    </td>
	                    
	                  </tr>
					       <?php $i++; ?>
	              <?php  }?>
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

