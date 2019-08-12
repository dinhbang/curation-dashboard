<?php

namespace App\Http\Requests\Type;

use App\Http\Requests\RequestAdmin;
use Illuminate\Validation\Rule;

class CreateTypeRequest extends RequestAdmin
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'country_id' => 'required'
        ];
    }
}
