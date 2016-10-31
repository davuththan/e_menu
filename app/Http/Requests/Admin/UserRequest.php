<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\Request;

//class PermissionRequest extends Request
class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	
        	'group_id' => 'required',
            'username' => 'required|unique:user',
            'password' => 'required|confirmed',
            // 'email' => 'email|max:255|unique:user',
        ];
    }

    public function messages()
    {
        return [
    
            'group_id.required' => 'Choose Group!',
            'username.required' => 'Provide name!',
            'password.required' => 'Provide password!',
        ];
    }
}
