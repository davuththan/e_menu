@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        {!!$view_title!!}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('design/common.design')!!}</a></li>
        <li><a href="#">{!!trans('design/banners.banner_name')!!}</a></li>
        <li class="active">{!!trans('common.listing')!!}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">{!!trans('common.view_all')!!}</h3>
             <div class="pull-right">
             	<span>
             		<a class="btn btn-primary" href="{{url('admin/design/banner/create')}}">
             			<i class="fa fa-wa fa-pencil">
             			</i> {!!trans('common.add_new')!!}
             		</a>
             	</spa>
             </div>
            </div><!-- /.box-header -->

            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>{!!trans('design/banner.no')!!}</th>
                    <th>{!!trans('design/banner.banner_name')!!}</th>
                    <th>{!!trans('design/banner.status')!!}</th>
                    <th>{!!trans('design/banner.action')!!}</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $i = 1;?>
	                @foreach ($banners as $banner)
	                  <tr>
	                  	<td width="50"><?php echo($i); ?></td>
	                    <td>{{ $banner['name']}}</td>
                      <td>
                        @if($banner->is_active==1)
                          <button class="btn btn-success btn-xs">Active</button>
                        @else
                          <button class="btn btn-danger btn-xs">Inactive</button>
                        @endif
                      </td>
	                    <td width="250">
	                      <a href="{{route('admin.design.banner.show',$banner['id'])}}" class="btn btn-info"> <i class="fa fa-info"></i> </a>
	                    
	                      <a href="{{route('admin.design.banner.edit',$banner['id'])}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
			                
		                     <a href="{{route('admin.design.banner.destroy',$banner['id'])}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
		                     	<i class="fa fa-trash"></i>
		                     </a>
	                    </td>   
	                  </tr>
					         <?php $i++; ?>
	               @endforeach
                
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

