<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
	protected $table = 'event_description';
	protected $fillable = ['language_id','name','description','meta_keyword','meta_description'];
	public $timestamps = true;
	
}
