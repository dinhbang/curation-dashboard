<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\RequestAdmin;

class CreateCategoryRuleRequest extends RequestAdmin
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'=>'required',
            'rule_id'=>'required',
        ];
    }
}
