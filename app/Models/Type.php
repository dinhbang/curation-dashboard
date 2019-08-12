<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    //use SoftDeletes;
    protected $fillable = ['name','country_id'];
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function hasCategory() {
        return $this->hasMany(Category::class,'type_id');
    }
}
