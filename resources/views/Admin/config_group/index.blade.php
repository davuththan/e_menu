@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Config Group
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
             <!-- <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/setting/config_group/create')}}';">
             			<i class="fa fa-wa fa-plus">
             			</i> Add New
             		</button>
             		
             	</spa>
             </div> -->
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                   
                   
                    <th>Name</th>
                    
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
	                   
	                    <td>{{ $data->name }}</td>
                      
	                    
	                    <td width="250">
	                      <a href="{{route('admin.setting.config_group.edit',$data->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
	                      <!-- <a href="{{route('admin.setting.config_group.destroy',$data->id)}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
                          <i class="fa fa-trash"></i>
                        </a> -->
                      </td>
	                    
	                  </tr>
					       <?php $i++; ?>
	              <?php  }?>
                </tbody>
                
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

@endsection

