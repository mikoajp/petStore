<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PetService
{
    protected $apiBaseUrl = 'https://petstore.swagger.io/v2';

    public function getAvailablePets()
    {
        try {
            $response = Http::get("{$this->apiBaseUrl}/pet/findByStatus", ['status' => 'available']);
            if ($response->successful()) {
                return $response->json();
            }
            Log::error('Error fetching available pets: ' . $response->body());
            return ['error' => 'Failed to fetch available pets.'];
        } catch (\Exception $e) {
            Log::error('Exception fetching available pets: ' . $e->getMessage());
            return ['error' => 'Exception occurred while fetching available pets.'];
        }
    }

    public function getPet($id)
    {
        try {
            $response = Http::get("{$this->apiBaseUrl}/pet/{$id}");
            if ($response->successful()) {
                return $response->json();
            }
            Log::error('Error fetching pet: ' . $response->body());
            return ['error' => 'Failed to fetch pet.'];
        } catch (\Exception $e) {
            Log::error('Exception fetching pet: ' . $e->getMessage());
            return ['error' => 'Exception occurred while fetching pet.'];
        }
    }

    public function addPet($data)
    {
        try {
            $response = Http::post("{$this->apiBaseUrl}/pet", $data);
            if ($response->successful()) {
                return true;
            }
            Log::error('Error adding pet: ' . $response->body());
            return ['error' => 'Failed to add pet.'];
        } catch (\Exception $e) {
            Log::error('Exception adding pet: ' . $e->getMessage());
            return ['error' => 'Exception occurred while adding pet.'];
        }
    }

    public function updatePet($data)
    {
        try {
            $response = Http::put("{$this->apiBaseUrl}/pet", $data);
            if ($response->successful()) {
                return true;
            }
            Log::error('Error updating pet: ' . $response->body());
            return ['error' => 'Failed to update pet.'];
        } catch (\Exception $e) {
            Log::error('Exception updating pet: ' . $e->getMessage());
            return ['error' => 'Exception occurred while updating pet.'];
        }
    }

    public function deletePet($id)
    {
        try {
            $response = Http::delete("{$this->apiBaseUrl}/pet/{$id}");
            if ($response->successful()) {
                return true;
            }
            Log::error('Error deleting pet: ' . $response->body());
            return ['error' => 'Failed to delete pet.'];
        } catch (\Exception $e) {
            Log::error('Exception deleting pet: ' . $e->getMessage());
            return ['error' => 'Exception occurred while deleting pet.'];
        }
    }
}
