<?php

namespace App\Http\Requests\Country;

use App\Http\Requests\RequestAdmin;

class UpdateCountryRequest extends RequestAdmin
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $country = $this->getCountry();
        return [
            'name' => 'required|unique:countries,name,'.$country->id
        ];
    }
    protected function getCountry() {
        return $this->route('country');
    }
}
