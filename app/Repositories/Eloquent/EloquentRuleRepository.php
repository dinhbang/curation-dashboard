<?php

namespace App\Repositories\Eloquent;

use App\Models\Rule;
use App\Repositories\Contracts\RuleRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentRuleRepository extends AbstractRepository implements RuleRepository
{
    public function entity()
    {
        return Rule::class;
    }
    public function getAll() {
        return Rule::whereNull('deleted_at')->get();
    }
    /**
     * @Des get all Rule by category ID
     * @param $categoryId integer
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function getByCategory($categoryId) {
        return Rule::join('category_rules as cr','cr.rule_id','=','rules.id')
            ->where('cr.category_id',$categoryId)
            ->select(['rules.id','rules.name'])->get();
    }
    public function delete($id)
    {
        $rule = Rule::find($id);
        if($rule) {
            return $rule->delete();
        }
        return false;
    }
}
