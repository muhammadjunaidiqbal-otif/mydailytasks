<?php

namespace App\Models;


use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $fillable = ['name', 'route', 'icon', 'parent_id'];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_item_role', 'menu_item_id', 'role_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItems::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItems::class, 'parent_id');
    }
}
