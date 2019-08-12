<?php

namespace App\Http\Controllers;
use App\Models\Type;
use App\Repositories\Eloquent\EloquentTypeRepository;
use App\Http\Requests\Type\CreateTypeRequest;
use App\Http\Requests\Type\UpdateTypeRequest;
Use Exception;
class TypeController extends JsonController
{
    protected $typeRepo;
    public function __construct(EloquentTypeRepository $typeRepository)
    {
        $this->middleware('auth');
        $this->typeRepo = $typeRepository;
    }

    public function getList() {
        
    }
    /**
     * @Des create new rule
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function store(CreateTypeRequest $request)
    {
        try {
            $type = $this->typeRepo->create($request->all());
            if($type) {
                return $this->customJson($type,200);
            }
            return $this->customJson(['error'=>'Country is not added'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
    /**
     * @Des update existing type
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function update(UpdateTypeRequest $request,Type $type) {
        try {
            $this->typeRepo->update($type->id,$request->all());
            return $this->customJson($this->typeRepo->getList($type->country_id),200);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
    /**
     * @Des get all type by countryID ID
     * @param $countryId integer
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function getByCountry($countryId) {
        return $this->customJson($this->typeRepo->getList($countryId),200);
    }
    /**
     * @Des Delete country
     * @Author: Bang Truong
     * @Date: 11 Aug 19
     * @return Json
     */
    public function delete($typeId) {
        try {
            $result = $this->typeRepo->delete($typeId);
            if($result) {
                return $this->customJson(['Deleted is successfully!'],200);
            }
            return $this->customJson(['error'=>'Deleted is fail'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
}
