@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Widget
        <small> Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Widget Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Widget Listing</h3>
            </div><!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Possition</th>
                    <th>Ordering</th>
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
	                  	<td><?php echo($i); ?></td>
                      <td>{{ $alldata[$j]['name']}} </td>
	                    <td>{{ $alldata[$j]['layout_possition'] }}</td>
	                    <td>{{ $alldata[$j]['ordering'] }}</td>
                      <td>{{ $alldata[$j]['is_active'] }}</td>
	                    
	                    <td width="150">	                    
	                      <a href="{{route('admin.setting.widget.show',$alldata[$j]['id'])}}" class="btn btn-info"><i class="fa fa-info"></i></a>
	                      <a href="{{route('admin.setting.widget.edit',$alldata[$j]['id'])}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
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

