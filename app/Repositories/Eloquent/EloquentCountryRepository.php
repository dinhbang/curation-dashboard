<?php

namespace App\Repositories\Eloquent;
use App\Models\Country;
use App\Repositories\Contracts\CountryRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentCountryRepository extends AbstractRepository implements CountryRepository
{
    public function entity()
    {
        return Country::class;
    }
    public function getAll() {
        return Country::orderBy('name','DESC')->get();
    }
    public function delete($countryId) {
        $country = Country::find($countryId);
        if($country) {
            return $country->delete();
        }
        return false;
    }
}
