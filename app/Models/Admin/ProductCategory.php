<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
	protected $table = 'product_category';
	protected $fillable = ['icon','name','order_level','created_by','updated_by'];
 
	public $timestamps = true;
	
}
