@extends('bo.common.layout') 

@section('content')

<div class="box">
	@include('common.message')
   <div class="box-header with-border">
     <!-- <h3 class="box-title">Cycle Type</h3> -->
     <a href="{{url('admin/cmgr/candidate/create')}}" class="btn btn-info">Create</a>
   </div><!-- /.box-header -->
   <div class="box-body">
     <table class="table table-bordered">
       <tr>
         <th style="width: 4%">No.</th>
         <th>Name</th>
         <th>Email</th>
         <th>Contact</th>
         <th>Address</th>
         <th colspan="2" style="text-align: center;">Action</th>
       </tr>
      <?php $i=1 ?>
        @foreach ($data as $row)
	       <tr>
	         <td><a href="{{route('admin.cmgr.news.edit',$row->id)}}">{{$row->id}}</a></td>
	         <td>{{$row->name}}</td>
	         <td>{{$row->email}}</td>
           <td>{{$row->contact}}</td>
           <td>{{$row->address}}</td>
	         <td style="text-align: center;width: 15%;">
	         	<span style="cursor: pointer;">
	         		<a title="Delete" href="{{route('admin.cmgr.candidate.destroy',$row->id)}}" class="btn btn-small" data-method="delete" data-confirm="Do you want to disable?">
	         			<i class="fa fa-fw fa-trash-o"></i>
	         		</a>
	         	</span>
	         </td>
           
          <?php $i++; ?>
       @endforeach
     </table>
   </div><!-- /.box-body -->
   <div class="box-footer text-right">
   	{!! $data->render() !!}
   </div>
   
 </div><!-- /.box -->
 
@endsection
