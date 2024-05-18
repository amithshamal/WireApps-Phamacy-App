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
        $customer_create = Permission::create(['name' => 'customer.create']);
        $customer_update = Permission::create(['name' => 'customer.update']);
        $customer_delete = Permission::create(['name' => 'customer.delete']);
        $customer_permanently_delete = Permission::create(['name' => 'customer.permanently.delete']);

        $medication_create = Permission::create(['name' => 'medication.create']);
        $medication_update = Permission::create(['name' => 'medication.update']);
        $medication_delete = Permission::create(['name' => 'medication.delete']);
        $medication_permanently_delete = Permission::create(['name' => 'medication.permanently.delete']);

        //create Roles
        $admin_role = Role::create(['name' => 'admin']);
        $manager_role = Role::create(['name' => 'manager']);
        Role::create(['name' => 'cashier']);

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
