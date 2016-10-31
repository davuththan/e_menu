<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model {
	//protected $primaryKey = 'bus_id';
	protected $table = 'activity_log';
	protected $fillable = ['user_id',
							'action',
							'menu_code',
							'create_at'
	];
	public $timestamps = false;
	
	public function user(){
		return $this->belongsTo('App\Models\Admin\UserModel','user_id');
	}
	
}
