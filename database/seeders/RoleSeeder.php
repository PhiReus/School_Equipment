<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = ['Device', 'Group', 'BorrowDevice', 'Borrow', 'User', 'Room', 'Role'];
        $actions = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete', 'trash'];
        foreach ($groups as $group) {
            foreach ($actions as $action) {
                DB::table('roles')->insert([
                    'name' => $group . '_' . $action,
                    'group_name' => $group,
                ]);
            }
        }
    }
}
