<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\RequestAdmin;

class CreateCategoryRequest extends RequestAdmin
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_id'=>'required',
        ];
    }
}
