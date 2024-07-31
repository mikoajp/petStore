<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\PetService;
use Mockery;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_error_when_service_fails()
    {
        $mock = Mockery::mock(PetService::class);
        $mock->shouldReceive('getAvailablePets')->andReturn(['error' => 'Failed to fetch available pets.']);
        $this->app->instance(PetService::class, $mock);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Failed to fetch available pets.');
    }

    public function test_store_shows_error_when_service_fails()
    {
        $mock = Mockery::mock(PetService::class);
        $mock->shouldReceive('addPet')->andReturn(['error' => 'Failed to add pet.']);
        $this->app->instance(PetService::class, $mock);

        $response = $this->post('/pets', [
            'name' => 'Test Pet',
            'status' => 'available'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['error' => 'Failed to add pet.']);
    }

}
