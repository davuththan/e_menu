<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\Request;

//class PermissionRequest extends Request
class ContentRequest extends Request
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
            'menu_type_id' => 'required',
            'fmenu_id' => 'required'
        ];
    }
}
