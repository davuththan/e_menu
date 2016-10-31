@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Front Menu
        <small> Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Front Menu Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Front Menu Listing</h3>
             <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/menu_mgr/fmenu/create')}}';">
             			<i class="fa fa-wa fa-plus">
             			</i> Add New
             		</button>
             	</span>
             </div>
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                   
                    <th>Menu Type</th>
                    <th>Menu Name</th>
                    <th>URL</th>
                    <th>Ordering</th>
                    <th>Is Active</th>
                    <th>Action</th>
                  </tr>
                </thead> 
                <tbody>
                	<?php $i = 1;?>
                  <?php   
                  //print_r($allfmenu); exit;               
	                for($j=0;$j<sizeof($allfmenu);$j++){
	                ?>
	                  <tr>
	                  	<td width="10"><?php echo($i); ?></td>
	                   
	                    <td>{{ $allfmenu[$j]['manu_type_name'] }}</td>
                      <td>{{ $allfmenu[$j]['menu_name']}} </td>
                      <td>{{ $allfmenu[$j]['url']}} </td>
                      <td>{{ $allfmenu[$j]['ordering']}} </td>
                      <td>
                        @if($allfmenu[$j]['is_active']==1)
                        <button class="btn btn-success btn-xs">Active</button>
                        @else
                        <button class="btn btn-success btn-xs">Inactive</button>
                        @endif
                      </td>
	                    
	                    <td>
	                   
	                      <a href="{{route('admin.menu_mgr.fmenu.edit',$allfmenu[$j]['id'])}}" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a>

                        <a href="{{route('admin.menu_mgr.fmenu.destroy',$allfmenu[$j]['id'])}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
                          <i class="fa fa-trash"></i>
                         </a>
			                 
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

