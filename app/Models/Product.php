<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id'];
    protected $dates = ['sale_end'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
