<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UsefulInfoCategory extends Model
{
	protected $table = 'useful_infocategory';
	protected $fillable = ['name','order_level','modified_by'];
 
	public $timestamps = true;
	
}
