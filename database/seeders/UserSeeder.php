<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //create Permission
        $customer_create = Permission::create(['name' => 'customer.create','guard_name' => 'sanctum']);
        $customer_update = Permission::create(['name' => 'customer.update','guard_name' => 'sanctum']);
        $customer_delete = Permission::create(['name' => 'customer.delete','guard_name' => 'sanctum']);
        $customer_permanently_delete = Permission::create(['name' => 'customer.permanently.delete','guard_name' => 'sanctum']);

        $medication_create = Permission::create(['name' => 'medication.create','guard_name' => 'sanctum']);
        $medication_update = Permission::create(['name' => 'medication.update','guard_name' => 'sanctum']);
        $medication_delete = Permission::create(['name' => 'medication.delete','guard_name' => 'sanctum']);
        $medication_permanently_delete = Permission::create(['name' => 'medication.permanently.delete','guard_name' => 'sanctum']);

        //create Roles
        $admin_role = Role::create(['name' => 'admin','guard_name' => 'sanctum']);
        $manager_role = Role::create(['name' => 'manager','guard_name' => 'sanctum']);
        Role::create(['name' => 'cashier','guard_name' => 'sanctum']);

        //assign permissions to role
        $admin_role->givePermissionTo([
            $customer_create, $customer_update, $customer_delete, $customer_permanently_delete,
            $medication_create, $medication_update, $medication_delete, $medication_permanently_delete
        ]);
        $manager_role->givePermissionTo([$customer_update, $customer_delete, $medication_update, $medication_delete]);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin@admin.com',
            'password' => bcrypt("password"),
            'role' => 'admin'
        ]);
        $admin->assignRole($admin_role);
    }
}
