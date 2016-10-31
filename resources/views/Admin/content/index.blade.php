@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Content
        <small> Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Content Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Content Listing</h3>
             <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/cmgr/content/create')}}';">
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
                   
                    <th>Menu Type</th>
                    <th>Menu Name</th>
                    <th>Menu Link</th>
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
                     
                      <td>{{ $allfmenu[$j]['menu_type_name'] }}</td>
                      <td>{{ $allfmenu[$j]['menu_name']}} </td>                     
                      <td>{{ $allfmenu[$j]['menu_link'] }}</td>
                      <td width="50">{{ $allfmenu[$j]['url'] }}</td>
                      <td>{{ $allfmenu[$j]['ordering']}} </td>
                      <td>
                        @if($allfmenu[$j]['is_active']==1)
                        <span>Active</span>
                        @else
                        <span>Inactive</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{route('admin.cmgr.content.show',$allfmenu[$j]['cid'])}}" class="btn btn-info"><i class="fa fa-info"></i></a>
                        <a href="{{route('admin.cmgr.content.edit',$allfmenu[$j]['cid'])}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
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

