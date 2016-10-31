@extends('Admin.common.layout')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>{!! $view_title !!}</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{!! $view_sub_title !!}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">{!! $view_sub_title !!}</h3>
             <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/cmgr/quick_link/create')}}';">
             			<i class="fa fa-wa fa-plus">
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
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Is Active?</th>
                    <th>Action</th>
                  </tr>
                </thead> 
                <tbody>
                	<?php $i = 1;?>   
	                 @foreach ($data as $key => $value)
	                  <tr>
	                  	<td width="50">{{ $i }}</td>
                      <td style="background-color:#2196F3;"><img src="{{ SITE_HTTP_URL}}/images/uploads/quick_link/{{$value->thumbnail}}" width="40px"> </td>
                      <td>{{ $value->title}} </td>
                      <td>{{ $value->url}} </td>
                      <td>
                        @if($value->is_active==1)
                          Active
                        @else
                          Inactive
                        @endif
                      </td>
	                    <td width="250">
	                      <a title="View" href="{{route('admin.cmgr.quick_link.show',$value->id)}}" class="btn btn-info"><i class="fa fa-info"></i></a>
	                      <a title="Edit" href="{{route('admin.cmgr.quick_link.edit',$value->id)}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
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

