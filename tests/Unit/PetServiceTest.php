<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PetService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PetServiceTest extends TestCase
{
    public function test_getAvailablePets_handles_error()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/findByStatus?status=available' => Http::response(null, 500)
        ]);

        $petService = new PetService();
        $result = $petService->getAvailablePets();

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Failed to fetch available pets.', $result['error']);
    }

    public function test_getPet_handles_error()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/*' => Http::response(null, 500)
        ]);

        $petService = new PetService();
        $result = $petService->getPet(1);

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Failed to fetch pet.', $result['error']);
    }

}
