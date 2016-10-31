@extends('bo.common.layout') 

@section('content')

<div class="box">
	@include('common.message')
   <div class="box-header with-border">
     <!-- <h3 class="box-title">Cycle Type</h3> -->
     <a href="{{url('admin/cmgr/project_category/create')}}" class="btn btn-info">Create</a>
   </div><!-- /.box-header -->
   <div class="box-body">
     <table class="table table-bordered">
       <tr>
         <th style="width: 4%">#</th>
         <th>Image</th>
         <th>Name</th>
         <th>Description</th>
         <th style="width: 5%">Action</th>
       </tr>
        @foreach ($data as $row)
	       <tr>
	         <td><a href="{{route('admin.cmgr.project_category.edit',$row->id)}}">{{$row->id}}</a></td>
	         <td><a href="{{route('admin.cmgr.project_category.edit',$row->id)}}"><img style="width: 50px;" alt="picture" src="{{url('images/upload')}}/{{$row->image}}"/></a></td>
	         <td>{{$row->name}}</td>
           <td>{{$row->description}}</td>
	         <td>
	         	<span style="cursor: pointer;">
	         		<a href="{{route('admin.cmgr.project_category.destroy',$row->id)}}" class="btn btn-small" data-method="delete" data-confirm="Do you want to disable?">
	         			<i class="fa fa-fw fa-trash-o" style="color:red"></i>
	         		</a>
	         	</span>
	         </td>
	       </tr>
       @endforeach
     </table>
   </div><!-- /.box-body -->
   <div class="box-footer text-right">
   	{!! $data->render() !!}
   </div>
   
 </div><!-- /.box -->
 
@endsection
