@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Content Category
        <small> Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Content Category Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Content Category Listing</h3>
             <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/content_category/create')}}';">
             			<i class="fa fa-wa fa-plus">
             			</i> Add New
             		</button><!-- &nbsp;&nbsp;
             		<button class="btn btn-danger" onclick="location.href ='#';">
             			<i class="fa fa-wa fa-trash">
             			</i> Trash
             		</button> -->
             	</spa>
             </div>
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>                   
                    <th>Parent</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Is Active</th>
                    <th>Action</th>
                  </tr>
                </thead> 
                <tbody>
                	<?php $i = 1;?>
                  <?php   
                          
	                for($j=0;$j<sizeof($alldata);$j++){
	                ?>
	                  <tr>
	                  	<td width="50"><?php echo($i); ?></td>
	                   
	                    <td>{{ $alldata[$j]['parent_name'] }}</td>
                      <td>{{ $alldata[$j]['name']}} </td>
	                    <td><img src="{{ $alldata[$j]['image'] or 'No image' }}" alt="" height="50"></td>
	                    <td>{{ $alldata[$j]['is_active'] }}</td>
	                    
	                    <td width="250">
	                    
	                      <!-- <a href="{{route('admin.content_category.show',$alldata[$j]['id'])}}" class="btn btn-info"><i class="fa fa-eye"></i> View</a> -->
	                      <a href="{{route('admin.content_category.edit',$alldata[$j]['id'])}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
			                
		                    <a href="{{route('admin.content_category.destroy',$alldata[$j]['id'])}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
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

