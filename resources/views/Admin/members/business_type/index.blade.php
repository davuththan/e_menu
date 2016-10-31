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
        <li><a href="#"><i class="fa fa-home"></i> {!!trans('members/common.members')!!}</a></li>
        <li><a href="#">{!!trans('members/business_type.business_type')!!}</a></li>
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
             		<a class="btn btn-primary" href="{{url('admin/members/business_type/create')}}">
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
                    <th>{!!trans('members/business_type.no')!!}</th>
                    <th>{!!trans('members/business_type.business_type')!!}</th>
                    <th>{!!trans('members/business_type.action')!!}</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $i = 1;?>
	                @foreach ($business_types as $business_type)
	                  <tr>
	                  	<td width="50"><?php echo($i); ?></td>
	                    <td>{{ $business_type->name}}</td>
	                    <td width="250">
	                      <a href="{{route('admin.members.business_type.show',$business_type->id)}}" class="btn btn-info"> <i class="fa fa-info"></i> </a>
	                    
	                      <a href="{{route('admin.members.business_type.edit',$business_type->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
			                
		                     <a href="{{route('admin.members.business_type.destroy',$business_type->id)}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
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

