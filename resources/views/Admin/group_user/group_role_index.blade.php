@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if(Session::has('message'))
        <div class="alert alert-success">
            {{Session::get('message')}}
        </div>
      @endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Group Users
        <small>Group Users Listing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Group Users</a></li>
        <li class="active">Group Users Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Group Users Listing</h3>
             <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/user_mgr/group_role/create')}}';">
             			<i class="fa fa-wa fa-pencil">
             			</i> Add New
             		</button>
             	</spa>
             </div>
            </div><!-- /.box-header -->
   
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Remark</th>
                    <th>Action</th>
                    
                  </tr>
                </thead>
                <tbody>
                
                <?php $i = 1;?>
                
	                @foreach ($allrole as $role)
	                
	                  <tr>
	                  	<td><?php echo($i); ?></td>
	                    <td>{{ $role -> name }}</td>
	                    <td>{{ $role -> group_user->name }}</td>
	                    <td>{{ $role -> remark }}</td>
	                    
	                    <td>
	                    	 
	                    	 <a href="{{route('admin.user_mgr.group_role.show',$role->id)}}" class="btn btn-success" title="Permission"><i class="fa fa-key"></i></a>
	                    	 <a href="{{route('admin.user_mgr.group_role.edit',$role->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
		                     <a href="{{route('admin.user_mgr.group_role.destroy',$role->id)}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
		                     	<i class="fa fa-trash"></i>
		                     </a>
		                     
	                    </td>
	                    
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

