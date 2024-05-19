<?php

namespace Tests\Feature;

use App\Models\Medication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class MedicationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs($user = User::factory()->create());
    }

    public function test_index_returns_all_medications()
    {
        $medications = Medication::factory()->create();

        $response = $this->getJson('/api/medications');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data')
            ->assertJsonMissing(['medication_id' => 2])
            ->assertJsonPath('data.0.name', $medications->name)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'medication_id',
                        'name',
                        'description',
                        'quantity'
                    ]
                ]
            ]);
    }

    public function test_store_creates_medication_with_valid_data_and_permission()
    {
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->randomNumber()
        ];

        $role = Role::create(['name' => 'manager']);

        $medication_create = Permission::create(['name' => 'medication.create']);
        $role->givePermissionTo([
            $medication_create
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->postJson('/api/medications', $data,['Accept' => 'application/json']);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('medications', $data);
    }




    public function test_store_returns_unauthorized_without_permission()
    {
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->randomNumber()
        ];

        $this->actingAs($user = User::factory()->create()); // No permission granted

        $response = $this->postJson('/api/medications', $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertDatabaseMissing('medications', $data);
    }

    public function test_show_returns_medication_by_id()
    {
        $medication = Medication::factory()->create();

        $response = $this->getJson('/api/medications/' . $medication->id);

        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.name', $medication->name)
        ->assertJsonMissing(['medication_id' => 2])
        ->assertJsonPath('status',true);
    }

    public function test_update_updates_medication_with_valid_data_and_permission()
    {
        $medication = Medication::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->randomNumber()
        ];

        $role = Role::create(['name' => 'manager']);

        $medication_create = Permission::create(['name' => 'medication.update']);
        $role->givePermissionTo([
            $medication_create
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->putJson('/api/medications/' . $medication->id, $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissing(['data.name', $medication->name])
            ->assertJsonPath('status', true);

        $this->assertDatabaseHas('medications', $data);
    }

    public function test_update_returns_unauthorized_without_permission()
    {
        $medication = Medication::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->randomNumber()
        ];

        $this->actingAs($user = User::factory()->create());

        $response = $this->putJson('/api/medications/' . $medication->id, $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
                ->assertJsonPath('status', false);

        $this->assertDatabaseMissing('medications', $data);
    }

    public function test_destroy_deletes_medication_with_valid_permission()
    {
        $medication = Medication::factory()->create();

        $role = Role::create(['name' => 'admin']);

        $medication_create = Permission::create(['name' => 'medication.delete']);
        $role->givePermissionTo([
            $medication_create
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->deleteJson('/api/medications/' . $medication->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('status', true);
    }



    public function test_destroy_returns_unauthorized_without_permission()
    {
        $medication = Medication::factory()->create();

        $this->actingAs($user = User::factory()->create()); // No permission granted

        $response = $this->deleteJson('/api/medications/' . $medication->id);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonPath('status', false);

        $this->assertDatabaseHas('medications', ['id' => $medication->id]);  // medication not deleted
    }
}
