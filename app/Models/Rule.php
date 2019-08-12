<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    //use SoftDeletes;
    protected $fillable = ['name','description'];
    public function hasCategoryRule() {
        return $this->hasMany(CategoryRule::class,'rule_id');
    }
    public function delete()
    {
        $this->hasCategoryRule()->delete();
        return parent::delete(); 
    }
}
