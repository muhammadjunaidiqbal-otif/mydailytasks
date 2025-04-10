<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    
    protected $guarded = ['id'];

        
    // Add fields to the $fillable property
    // protected $fillable = [
    //     'title',         // Make sure 'title' is in the array
    //     'slug',
    //     'description',
    //     'status',
    //     'parent_id',     // If applicable, add other fields you want to mass-assign
    //     'image',         // Add image if you want to allow image upload
    // ];
}
