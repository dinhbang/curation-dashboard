<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\RequestAdmin;

class CreateAllRequest extends RequestAdmin
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_name'=>'required',
            'type_name'=>'required'
        ];
    }
}
