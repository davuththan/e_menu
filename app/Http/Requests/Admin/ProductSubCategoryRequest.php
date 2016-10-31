<?php  

namespace App\Http\Requests\Admin;
use App\Http\Requests\Request;

//class PermissionRequest extends Request
class ProductSubCategoryRequest extends Request
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
            'name_kh' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'pc_id.required' => 'Please choose category!',
            'name_en.required' => 'Sub Category Name In English is required!',
            'name_kh.required' => 'Sub Category Name In Khmer is required!',
        ];
    }
}
