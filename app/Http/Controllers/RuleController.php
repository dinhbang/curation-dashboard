<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rule\CreateRuleRequest;
use App\Http\Requests\Rule\UpdateRuleRequest;
use App\Models\Rule;
use App\Repositories\Eloquent\EloquentRuleRepository;
use Exception;

class RuleController extends JsonController
{
    protected $ruleRepo;
    public function __construct(EloquentRuleRepository $ruleRepository)
    {
        $this->middleware('auth');
        $this->ruleRepo = $ruleRepository;
    }

    /**
     * @Des get all Rule
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function getList() {
        return $this->customJson($this->ruleRepo->getAll(),200);
    }
    /**
     * @Des create new rule
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function store(CreateRuleRequest $request)
    {
        try {
            $rule = $this->ruleRepo->create($request->all());
            if($rule) {
                /**
                 * return all rule after save new rule
                 */
                $rules = $this->ruleRepo->getAll();
                return $this->customJson($rules,200);
            }
            return $this->customJson(['error'=>'Country is not added'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
    /**
     * @Des update existing rule
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function update(UpdateRuleRequest $request,Rule $rule) {
        try {
            $this->ruleRepo->update($rule->id,$request->all());
            return $this->customJson($this->ruleRepo->getAll(),200);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }

    /**
     * @Des get all Rule by category ID
     * @param $categoryId integer
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function getByCategory($categoryId) {
        return $this->customJson($this->ruleRepo->getByCategory($categoryId),200);
    }
    /**
     * @Des Delete country
     * @Author: Bang Truong
     * @Date: 11 Aug 19
     * @return Json
     */
    public function delete($ruleId) {
        try {
            $result = $this->ruleRepo->delete($ruleId);
            if($result) {
                return $this->customJson(['Deleted is successfully!'],200);
            }
            return $this->customJson(['error'=>'Deleted is fail'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }

}
