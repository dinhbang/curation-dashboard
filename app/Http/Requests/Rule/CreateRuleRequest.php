<?php

namespace App\Http\Requests\Rule;

use App\Http\Requests\RequestAdmin;

class CreateRuleRequest extends RequestAdmin
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:rules,name'
        ];
    }
}
