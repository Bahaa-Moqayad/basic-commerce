<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id')->withDefault();
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function child()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
}
