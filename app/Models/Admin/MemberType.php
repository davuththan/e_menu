<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
	protected $table = 'member_type';
	protected $fillable = ['name','modified_by'];
 
	public $timestamps = true;
	
}
