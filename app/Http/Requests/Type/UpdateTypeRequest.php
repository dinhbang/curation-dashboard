<?php

namespace App\Http\Requests\Type;

use App\Http\Requests\RequestAdmin;

class UpdateTypeRequest extends RequestAdmin
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type = $this->getType();
        return [
            'name' => 'required',
            'country_id' => 'required|unique:types,country_id,NULL,id,name,'.$type->id
        ];
    }
    protected function getType() {
        return $this->route('type');
    }
}
