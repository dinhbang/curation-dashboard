<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\CategoryRule;
use App\Models\Country;
use App\Models\Rule;
use App\Models\Type;
use App\Repositories\Contracts\CategoryRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentCategoryRepository extends AbstractRepository implements CategoryRepository
{
    public function entity()
    {
        return Category::class;
    }

    public function getList()
    {
        $countries = Country::whereNull('deleted_at')->get();
        $types = Type::whereNull('deleted_at')->get();
        $categories = Category::whereNull('deleted_at')->get();

        $categoryRules = Category::leftJoin('category_rules as cr', 'categories.id', '=', 'cr.category_id')
            ->leftJoin('rules as r', 'r.id', '=', 'cr.rule_id')
            ->join('types as t', 't.id', '=', 'categories.type_id')
            ->join('countries', 'countries.id', '=', 't.country_id')
            ->select(['countries.name as country_name', 'categories.name', 'r.name as rule_name', 't.name as type_name', 'categories.id as id', 'countries.id as country_id', 't.id as type_id', 'r.id as rule_id'])
            ->get()
        ;

        $rules = Rule::whereNull('deleted_at')->get();

        return [
            'countries' => $countries,
            'types' => $types,
            'rules' => $rules,
            'categories' => $categories,
            'categoryRules' => $categoryRules,
        ];
    }
    public function createRule(array $properties) {
        return CategoryRule::create($properties);
    }
    public function getRules($categoryId) {
        return CategoryRule::join('rules as r','r.id','category_rules.rule_id')
        ->where('category_rules.category_id',$categoryId)
        ->select(['category_rules.id','r.name','r.description','category_rules.rule_id'])
        ->get();
    }
    public function delete($categoryId)
    {
        $category = Category::find($categoryId);
        if($category) {
            return $category->delete();
        }
        return false;
    }
    public function deleteRule($categoryRuleId) {
        $categoryRule = CategoryRule::find($categoryRuleId);
        if($categoryRule) {
            return $categoryRule->delete();
        }
        return false;
    }
}
