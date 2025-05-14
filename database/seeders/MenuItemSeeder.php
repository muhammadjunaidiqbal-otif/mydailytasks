<?php

namespace Database\Seeders;

use App\Models\MenuItems;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            ['id' => 1, 'name' => 'Calendar', 'route' => 'calender.page', 'icon' => 'ti ti-calendar', 'parent_id' => null],
            ['id' => 3, 'name' => 'Products', 'route' => null, 'icon' => 'ti ti-pyramid', 'parent_id' => null],
            ['id' => 4, 'name' => 'Product List', 'route' => 'products-list', 'icon' => null, 'parent_id' => 3],
            ['id' => 5, 'name' => 'Add Product', 'route' => 'add-products', 'icon' => null, 'parent_id' => 3],
            ['id' => 6, 'name' => 'Category List', 'route' => 'products-category-list', 'icon' => null, 'parent_id' => 3],
            ['id' => 7, 'name' => 'Order', 'route' => null, 'icon' => 'ti ti-ti ti-truck', 'parent_id' => null],
            ['id' => 8, 'name' => 'Order List', 'route' => 'orders-list-page', 'icon' => null, 'parent_id' => 7],
            ['id' => 9, 'name' => 'Order Details', 'route' => null, 'icon' => null, 'parent_id' => 7],
            ['id' => 10, 'name' => 'Roles & Permissions', 'route' => null, 'icon' => 'ti ti-settings', 'parent_id' => null],
            ['id' => 11, 'name' => 'Roles', 'route' => 'roles-page', 'icon' => null, 'parent_id' => 10],
            ['id' => 12, 'name' => 'Permission', 'route' => 'permissions-page', 'icon' => null, 'parent_id' => 10],
            ['id' => 13, 'name' => 'User Profile', 'route' => null, 'icon' => 'ti ti-file', 'parent_id' => null],
            ['id' => 14, 'name' => 'Profile', 'route' => 'user.profile', 'icon' => null, 'parent_id' => 13],
            ['id' => 15, 'name' => 'Datatables', 'route' => null, 'icon' => 'ti ti-layout-grid', 'parent_id' => null],
            ['id' => 16, 'name' => 'Users', 'route' => 'users.datatable', 'icon' => null, 'parent_id' => 15],
            ['id' => 17, 'name' => 'Reports', 'route' => null, 'icon' => 'ti ti-report', 'parent_id' => null],
            ['id' => 18, 'name' => 'Orders Report', 'route' => 'orders-report-page', 'icon' => null, 'parent_id' => 17],

            
        ];
        foreach ($menuItems as $item) {
            MenuItems::updateOrCreate(
                ['id' => $item['id']], // Condition to check
                $item // Values to insert or update
            );
        }
        // $roleMenuItems = [
        //     ['menu_item_id' => 1, 'role_id' => 1],
        //     ['menu_item_id' => 3, 'role_id' => 1],
        //     ['menu_item_id' => 4, 'role_id' => 1],
        //     ['menu_item_id' => 5, 'role_id' => 1],
        //     ['menu_item_id' => 6, 'role_id' => 1],
        //     ['menu_item_id' => 7, 'role_id' => 1],
        //     ['menu_item_id' => 8, 'role_id' => 1],
        //     ['menu_item_id' => 9, 'role_id' => 1],
        //     ['menu_item_id' => 10, 'role_id' => 1],
        //     ['menu_item_id' => 11, 'role_id' => 1],
        //     ['menu_item_id' => 12, 'role_id' => 1],
        //     ['menu_item_id' => 13, 'role_id' => 1],
        //     ['menu_item_id' => 14, 'role_id' => 1],
        //     ['menu_item_id' => 15, 'role_id' => 1],
        //     ['menu_item_id' => 16, 'role_id' => 1],
        //     ['menu_item_id' => 7, 'role_id' => 2],
        //     ['menu_item_id' => 13, 'role_id' => 2],
        //     ['menu_item_id' => 7, 'role_id' => 2],
        //     ['menu_item_id' => 7, 'role_id' => 2],
        // ];
        // foreach ($roleMenuItems as $roleItem) {
        //     DB::table('menu_item_role')->upsert(
        //         ['menu_item_id' => $roleItem['menu_item_id'], 'role_id' => $roleItem['role_id']], 
        //         ['created_at' => now(), 'updated_at' => now()] 
        //     );
        // }
    }
}
