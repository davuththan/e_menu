<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\Request;

//class PermissionRequest extends Request
class PermissionRequest extends Request
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:2',
            'permission' => 'required|max:2'
        ];
    }
}
