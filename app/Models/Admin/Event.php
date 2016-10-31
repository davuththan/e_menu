<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $table = 'event';
	protected $fillable = ['parent_id','image','event_category_id','modified_by','event_start','event_end','publish_date','is_active','is_event','order_level'];
	public $timestamps = true;
	
	public function EventCategory($event_category_id){
		return $this->belongsTo('App\Models\Admin\EventCategory','event_category_id');
	}
}
