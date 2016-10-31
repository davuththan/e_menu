<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UsefulLink extends Model
{
	protected $table = 'useful_link';
	protected $fillable = ['name','url','modified_by'];
 
	public $timestamps = true;
	
}
