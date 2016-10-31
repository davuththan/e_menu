<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
	protected $table = 'event_category';
	protected $fillable = ['name','modified_by'];
	public $timestamps = true;
	
}
