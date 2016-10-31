<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\Request;

//class PermissionRequest extends Request
class UsefulInfoListingRequest extends Request
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
            'useful_InfoCategory_id' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'useful_InfoCategory_id.required' => 'Please Select Useful Info Category!',
            'name.required' => 'Name is required!',
        ];
    }
}
