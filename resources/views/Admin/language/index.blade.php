@extends('Admin.common.layout')

@section('content')

  <!-- language Wrapper. Contains page language -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Language
        <small> Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Language Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Language Listing</h3>
             <div class="pull-right">
             	<span>
             		<!-- <button class="btn btn-primary" onclick="location.href ='{{url('admin/language/create')}}';">
             			<i class="fa fa-wa fa-plus">
             			</i> Add New
             		</button> -->
             	</spa>
             </div>
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>                 
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Code</th>
                    
                    <th>Ordering</th>
                    
                    <th>Is Active</th>
                    <th>Action</th>
                  </tr>
                </thead> 
                <tbody>
                	<?php $i = 1;?>
                  <?php                           
	                foreach ($alldata as $data){
	                ?>
	                  <tr>
	                  	<td width="50"><?php echo($i); ?></td>
                      <td><img src="{{SITE_HTTP_URL.$data->image}}"> </td>
	                    <td>{{ $data->name }}</td>
                      <th>{{ $data->code }}</th>
                      <td>{{ $data->ordering }}</td>
                      
	                    <td>
@if($data->is_active==1)
                          Active
                        @else
                          Inactive
                        @endif 

</td>
	                    
	                    <td width="250">
                        <a title="View" href="{{route('admin.setting.language.show',$data->id)}}" class="btn btn-info"><i class="fa fa-info"></i></a>
                        
	                      <a href="{{route('admin.setting.language.edit',$data->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i> </a>
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

