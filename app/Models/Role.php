<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\MenuItems;

class Role extends SpatieRole
{
    public function menuItems()
    {
        return $this->belongsToMany(MenuItems::class, 'menu_item_role', 'role_id', 'menu_item_id');
    }

}
