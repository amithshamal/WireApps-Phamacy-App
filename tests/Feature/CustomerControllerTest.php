<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs($user = User::factory()->create());
    }

    public function test_index_returns_all_customers()
    {
        $customers = Customer::factory()->create();

        $response = $this->getJson('/api/customers');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data')
            ->assertJsonMissing(['customer_id' => 2])
            ->assertJsonPath('data.0.name', $customers->name)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'customer_id',
                        'name',
                        'email',
                        'phone'
                    ]
                ]
            ]);
    }

    public function test_store_creates_customer_with_valid_data_and_permission()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber
        ];

        $role = Role::create(['name' => 'manager']);

        $customer_create = Permission::create(['name' => 'customer.create']);
        $role->givePermissionTo([
            $customer_create
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->postJson('/api/customers', $data,['Accept' => 'application/json']);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('customers', $data);
    }




    public function test_store_returns_unauthorized_without_permission()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber
        ];

        $this->actingAs($user = User::factory()->create()); // No permission granted

        $response = $this->postJson('/api/customers', $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertDatabaseMissing('customers', $data);
    }

    public function test_show_returns_customer_by_id()
    {
        $customer = Customer::factory()->create();

        $response = $this->getJson('/api/customers/' . $customer->id);

        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.name', $customer->name)
        ->assertJsonMissing(['customer_id' => 2])
        ->assertJsonPath('status',true);
    }

    public function test_update_updates_customer_with_valid_data_and_permission()
    {
        $customer = Customer::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber
        ];

        $role = Role::create(['name' => 'manager']);

        $customer_create = Permission::create(['name' => 'customer.update']);
        $role->givePermissionTo([
            $customer_create
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->putJson('/api/customers/' . $customer->id, $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissing(['data.name', $customer->name])
            ->assertJsonPath('status', true);

        $this->assertDatabaseHas('customers', $data);
    }

    public function test_update_returns_unauthorized_without_permission()
    {
        $customer = Customer::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber
        ];

        $this->actingAs($user = User::factory()->create());

        $response = $this->putJson('/api/customers/' . $customer->id, $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
                ->assertJsonPath('status', false);

        $this->assertDatabaseMissing('customers', $data);
    }

    public function test_destroy_deletes_customer_with_valid_permission()
    {
        $customer = Customer::factory()->create();

        $role = Role::create(['name' => 'admin']);

        $customer_create = Permission::create(['name' => 'customer.delete']);
        $role->givePermissionTo([
            $customer_create
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('status', true);
    }



    public function test_destroy_returns_unauthorized_without_permission()
    {
        $customer = Customer::factory()->create();

        $this->actingAs($user = User::factory()->create()); // No permission granted

        $response = $this->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonPath('status', false);

        $this->assertDatabaseHas('customers', ['id' => $customer->id]);  // Customer not deleted
    }
}
