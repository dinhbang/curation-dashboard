<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','type_id'];
    public function type() {
        return $this->belongsTo(Type::class);
    }
    public function hasCategoryRule() {
        return $this->hasMany(CategoryRule::class,'category_id');
    }
    public function delete()
    {
        $this->hasCategoryRule()->delete();
        return parent::delete();
    }

    public function rules() {
        return $this->belongsToMany(CategoryRule::class,'category_id')
            ->join('rules','rules.id','=','category_rules.rule_id')
            ->select(['rules.id','rules.name']);
    }
}
