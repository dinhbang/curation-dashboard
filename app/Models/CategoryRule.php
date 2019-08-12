<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRule extends Model
{
    protected $fillable = ['category_id','rule_id'];
    public function category() {
        return $this->belongsToMany(Category::class,'category_id');
    }
    public function rules() {
        return $this->belongsToMany(Rule::class,'rule_id');
    }
}
