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
    /**
     * @Des function create country, type, category and rule in one action
     * @date 12 Aug 2019
     * @param $arrData
     * @return array
     */
    public function createAll($arrData) {
        $arrResult = [];
        $isCountryNew = false;
        // check country is existing
        $country = Country::where('name',$arrData['country_name'])->first();
        if(!$country) {
            $country = Country::create(['name'=>$arrData['country_name']]);
            $isCountryNew = true;
        }
        $arrResult['country'] = $country;
        if($country) {
            // check type existing
            $isTypeNew = false;
            $type = null;
            if($isCountryNew === false) {
                $type = Type::where('name',$arrData['type_name'])->where('country_id',$country->id)->first();
            }
            if(!$type) {
                // create type
                $type = Type::create(['name'=>$arrData['type_name'],'country_id'=>$country->id]);
                $isTypeNew = true;
            }
            if($type) {
                $arrResult['type'] = $type;
                if(isset($arrData['category_name'])) {
                    $isCatNew = false;
                    $category = null;
                    if($isTypeNew === false) {
                        $category = Category::where('name',$arrData['category_name'])->where('type_id',$type->id)->first();
                    }
                    if(!$category) {
                        $category = Category::create(['name'=>$arrData['category_name'],'type_id'=>$type->id]);
                        $isCatNew = true;
                    }
                    $arrResult['category'] = $category;
                    if(isset($arrData['rules']) && count($arrData['rules']) > 0) {
                        $arrCheckRule = [];
                        // check rule id is added or not to current category
                        if($isCatNew === false) {
                            $arrCheckRule = CategoryRule::where('category_id',$category->id)->pluck('rule_id')->toArray();
                            //dd($arrCheckRule);
                        }
                        $arrRuleCat = [];
                        foreach ($arrData['rules'] as $key=>$ruleId) {
                            if(!in_array($ruleId,$arrCheckRule)) {
                                $arrRuleCat[] = ['category_id'=>$category->id,'rule_id'=>$ruleId];
                            }
                        }
                        if($arrRuleCat) {
                            CategoryRule::insert($arrRuleCat);
                        }
                        $arrResult['category_rule'] = $arrRuleCat;
                    }
                }
            }
        }
        return $arrResult;
    }
}
