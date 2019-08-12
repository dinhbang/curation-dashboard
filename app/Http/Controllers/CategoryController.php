<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Request;
use App\Http\Requests\RequestAdmin;
use App\Models\Category;
use App\Models\CategoryRule;
use App\Http\Requests\Category\CreateCategoryRuleRequest;
use Exception;
use App\Repositories\Eloquent\EloquentCategoryRepository;
class CategoryController extends JsonController
{
    protected $categoryRepo;
    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        $this->middleware('auth');
        $this->categoryRepo = $categoryRepository;
    }
    /**
     * @Des create new category
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            $category = $this->categoryRepo->create($request->all());
            if($category) {
                /**
                 * return all rule after save new rule
                 */
                $rules = $this->categoryRepo->All();
                return $this->customJson($rules,200);
            }
            return $this->customJson(['error'=>'Category is not added'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
    /**
     * @Des update existing category
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function update(UpdateCategoryRequest $request,Category $category) {
        try {
            $this->categoryRepo->update($category->id,$request->all());
            return $this->customJson($this->categoryRepo->All(),200);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }

    public function getAll()
    {
        return $this->customJson($this->categoryRepo->getList());
    }
    public function getRules($categoryId) {
        return $this->customJson($this->categoryRepo->getRules($categoryId),200);
    }

    public function allData() {
        return $this->customJson($this->categoryRepo->getList(), 200);
    }
    /**
     * @Des Delete country
     * @Author: Bang Truong
     * @Date: 11 Aug 19
     * @return Json
     */
    public function delete($categoryId) {
        try {
            $result = $this->categoryRepo->delete($categoryId);
            if($result) {
                return $this->customJson(['Deleted is successfully!'],200);
            }
            return $this->customJson(['error'=>'Deleted is fail'],500);
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
    public function deleteRule($categoryRuleId) {
        try {
            $result = $this->categoryRepo->deleteRule($categoryRuleId);
            if($result) {
                return $this->customJson(['Deleted is successfully!'],200);
            }
            return $this->customJson(['error'=>'Deleted is fail'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
    /**
     * @Des create new category
     * @Author: Bang Truong
     * @Date: 10 Aug 19
     * @return Json
     */
    public function storeRule(CreateCategoryRuleRequest $request)
    {
        try {
            $categoryRule = $this->categoryRepo->createRule($request->all());
            if($categoryRule) {
                return $this->customJson(['Added is successfully!'],200);
            }
            return $this->customJson(['error'=>'Rule is not added'],500);
        } catch (Exception $e) {
            return $this->customJson(['error'=>'System has error'],500);
        }

    }
}
