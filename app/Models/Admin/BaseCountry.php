<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BaseCountry extends Model
{
	protected $table = 'base_country';
	protected $fillable = ['name','modified_by'];
 
	public $timestamps = true;
	
}
