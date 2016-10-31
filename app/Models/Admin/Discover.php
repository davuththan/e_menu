<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Discover extends Model {

	protected $table = 'discover';
	
	protected $fillable = ['image','is_active'];

	public $timestamps = false;
	

	
}
