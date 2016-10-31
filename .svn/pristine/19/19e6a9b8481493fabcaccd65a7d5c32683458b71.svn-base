@extends('bo.common.layout') 

@section('content')

<div class="box">
	@include('common.message')
   <div class="box-header with-border">
     <!-- <h3 class="box-title">Cycle Type</h3> -->
     <a href="{{url('admin/user_mgr/group_user/create')}}" class="btn btn-info">Create</a>
   </div><!-- /.box-header -->
   <div class="box-body">
     <table class="table table-bordered">
       <tr>
         <th style="width: 4%">#</th>
         <th>Name</th>
         <th>Remark</th>
         <!-- <th style="width: 5%">Action</th> -->
       </tr>
        @foreach ($data as $row)
	       <tr>
	         <td><a href="{{route('admin.user_mgr.group_user.edit',$row->id)}}">{{$row->id}}</a></td>
	         <td><a href="{{route('admin.user_mgr.group_user.edit',$row->id)}}">{{$row->name}}</a></td>
	         <td>{{$row->remark}}</td>
	         <!-- <td>
	         	<span style="cursor: pointer;">
	         		<a href="{{route('admin.user_mgr.group_user.destroy',$row->id)}}" class="btn btn-small" data-method="delete" data-confirm="Do you want to disable?">
	         			<i class="fa fa-fw fa-trash-o" style="color:red"></i>
	         		</a>
	         	</span>
	         </td> -->
	       </tr>
       @endforeach
     </table>
   </div><!-- /.box-body -->
   
 </div><!-- /.box -->
 
@endsection
