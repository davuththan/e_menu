<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

	protected $table = 'language';
	
	protected $fillable = ['name', 
						    'image',						   
						    'code',						   
						    'is_active',
						    'ordering'
							
	];

	//public $timestamps = false;
	
}
 