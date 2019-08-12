<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Repositories\Eloquent\EloquentCountryRepository;
use App\Http\Requests\Country\CreateCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use Exception;

class CountryController extends JsonController
{
    protected $countryRepo;
    public function __construct(EloquentCountryRepository $countryRepository)
    {
        $this->middleware('auth');
        $this->countryRepo = $countryRepository;
    }
    /**
     * @Des get all country
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function getList() {
        return $this->customJson($this->countryRepo->getAll(),200);
    }
    /**
     * @Des create new country
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function store(CreateCountryRequest $request)
    {
        try {
            $country = $this->countryRepo->create($request->all());
            if($country) {
                return $this->customJson($country,200);
            }
            return $this->customJson(['error'=>'Country is not added'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
    /**
     * @Des update existing country
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function update(UpdateCountryRequest $request,Country $country) {
        try {
            $this->countryRepo->update($country->id,$request->all());
            return $this->customJson($this->countryRepo->getAll(),200);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
    /**
     * @Des Delete country
     * @Author: Bang Truong
     * @Date: 11 Aug 19
     * @return Json
     */
    public function delete($countryId) {
        try {
            $result = $this->countryRepo->delete($countryId);
            if($result) {
                return $this->customJson(['Deleted is successfully!'],200);
            }
            return $this->customJson(['error'=>'Deleted is fail'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
}
