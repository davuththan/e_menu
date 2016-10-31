<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Information extends Model {

	protected $table = 'information';
	
	protected $fillable = ['name',
							'description',
							'modified_by'
							];

	public $timestamps = true;
	
}
