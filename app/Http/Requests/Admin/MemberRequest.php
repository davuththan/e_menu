<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\Request;

//class PermissionRequest extends Request
class MemberRequest extends Request
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
            'name' => 'required',
            'business_type_id' => 'required',
            'member_type_id' => 'required',
            'position_id' => 'required',
            'base_country_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Member Name field is required!',
            'business_type_id.required' => 'Please Choose Business Type!',
            'member_type_id.required' => 'Please Choose Member Type!',
            'position_id.required' => 'Please Choose Position!',
            'base_country_id.required' => 'Please Choose Base Country!'
        ];
    }
}
