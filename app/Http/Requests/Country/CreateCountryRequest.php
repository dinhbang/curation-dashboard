<?php

namespace App\Http\Requests\Country;

use App\Http\Requests\RequestAdmin;

class CreateCountryRequest extends RequestAdmin
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:countries,name'
        ];
    }
}
