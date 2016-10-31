@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Menu Type
        <small> Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Menu Type</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Menu Type Listing</h3>
             <!-- <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/menu_type/create')}}';">
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
	                      <a href="{{route('admin.menu_mgr.mtype.edit',$data->id)}}" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
	                      <a href="{{route('admin.menu_mgr.mtype.destroy',$data->id)}}" title="Delete" class="btn btn-danger" data-method="delete" data-confirm="Are you sure?">
                          <i class="fa fa-trash"></i>
                        </a>
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

