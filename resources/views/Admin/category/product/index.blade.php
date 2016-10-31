@extends('Admin.common.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        Catalog
        <small>Product Listing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Catalog</a></li>
        <li class="active">Product Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="with-border box-header">
             <h3 class="box-title">Product Listing</h3>
             <div class="pull-right">
             	<span>
             		<button class="btn btn-primary" onclick="location.href ='{{url('admin/category/product/create')}}';">
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
                    <th>Sub Category</th>
                    <th>Product Name / En</th>
                    <th>Product Name / Kh</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $i = 1;?>
	                @foreach ($products as $product)
	                
	                  <tr>
	                  	<td width="50"><?php echo($i); ?></td>
	                    
	                    <td>{{ $product ->ProductCategory->name }}</td>
                      <td>{{ $product ->ProductSubCategory->name_en }}</td>
                      <td>{{ $product ->name_en }}</td>
                      <td>{{ $product ->name_kh }}</td>
                      <td>{{ $product ->price }}</td>
	                    
	                    <td width="250">
	                    
	                      <a href="{{route('admin.category.product.show',$product->id)}}" class="btn btn-info"> <i class="fa fa-info"></i> </a>
	                    
	                      <a href="{{route('admin.category.product.edit',$product->id)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
			                
		                     <a href="{{route('admin.category.product.destroy',$product->id)}}" class="btn btn-danger" title="Delete" data-method="delete" data-confirm="Are you sure?">
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

