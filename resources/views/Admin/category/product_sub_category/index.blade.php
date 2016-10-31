@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Catalog
        <small>Sub Category Listing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Catalog</a></li>
        <li class="active">Sub Category Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Sub Category Listing</h3>
             <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/category/product_sub_category/create')}}';">
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
                    <th>Category</th>
                    <th>Sub Cateogory/English</th>
                    <th>Sub Cateogory/Khmer</th>
                    <th>Order Level</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $i = 1;?>
	                @foreach ($product_sub_categories as $product_sub_category)
	                
	                  <tr>
	                  	<td width="50"><?php echo($i); ?></td>
	                     
                      <td>{{ $product_sub_category ->ProductCategory ->name }}</td>

	                    <td>{{ $product_sub_category ->name_en }}</td>
                      <td>{{ $product_sub_category ->name_kh }}</td>
	                    <td>{{ $product_sub_category ->order_level }}</td>
	                    <td width="250">
	                    
	                      <a href="{{route('admin.category.product_sub_category.show',$product_sub_category->id)}}" class="btn btn-info"> <i class="fa fa-info"></i> </a>
	                    
	                      <a href="{{route('admin.category.product_sub_category.edit',$product_sub_category->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
			                
		                     <a href="{{route('admin.category.product_sub_category.destroy',$product_sub_category->id)}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
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

