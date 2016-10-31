<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
	protected $table = 'business_type';
	protected $fillable = ['name','modified_by'];
 
	public $timestamps = true;
	
}
