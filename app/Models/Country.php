<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];
    public function hasType() {
        return $this->belongsToMany(Type::class,'country_id')->join('categories as c','c.type_id','=','types.id')->join('category_rules as cr','cr.category_id','=','c.id')->get();
    }
}
