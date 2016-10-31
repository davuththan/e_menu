<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\Request;

//class PermissionRequest extends Request
class ProductRequest extends Request
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
            'pc_id' => 'required',
            'name_en' => 'required',
            'name_kh' => 'required',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'pc_id.required' => 'Please Choose Product Category!',
            'name_en.required' => 'Provide product name in Enlish!',
            'name_kh.required' => 'Provide product name in Khmer!',
            'price.required' => 'Price is required!',
        ];
    }
}
