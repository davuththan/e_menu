<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	protected $table = 'member';
	protected $fillable = ['name','image','member_type_id','business_type_id','position_id','company_representative','base_country','base_country_id','website','phone','address','description','email','remark','modified_by'];
 
	public $timestamps = true;
	
	public function MemberType(){
		return $this->belongsTo('App\Models\Admin\MemberType','member_type_id');
	}

	public function BusinessType(){
		return $this->belongsTo('App\Models\Admin\BusinessType','business_type_id');
	}

	public function BaseCountry(){
		return $this->belongsTo('App\Models\Admin\BusinessType','base_country_id');
	}

	public function Position(){
		return $this->belongsTo('App\Models\Admin\Position','position_id');
	}
}

