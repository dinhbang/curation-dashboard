<?php

namespace App\Repositories\Eloquent;

use App\Models\Type;
use App\Repositories\Contracts\TypeRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentTypeRepository extends AbstractRepository implements TypeRepository
{
    public function entity()
    {
        return Type::class;
    }
    public function getList($countryId) {
        if($countryId <= 0) {
            return [];
        }
        return Type::where('country_id',$countryId)->orderBy('name','ASC')->get();
    }

    /**
     * Delete type and reference categories and category rules
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $type = Type::find($id);
        if($type) {
            return $type->delete();
        }
        return false;
    }
}
