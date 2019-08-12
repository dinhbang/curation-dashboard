<?php

namespace App\Http\Requests\Rule;

use App\Http\Requests\RequestAdmin;

class UpdateRuleRequest extends RequestAdmin
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = $this->getRule();
        return [
            'name' => 'required|unique:rules,name,'.$rule->id
        ];
    }
    protected function getRule() {
        return $this->route('rule');
    }
}
