<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MedicineService
{
    private $baseUrl = 'https://recruitment.rsdeltasurya.com/api/v1';

    private function getToken()
    {
        return Cache::remember('api_token', 80000, function () {
            $response = Http::post($this->baseUrl . '/auth', [
                'email' => 'renggaarnanta@gmail.com',
                'password' => '083830330276'
            ]);

            if ($response->failed()) {
                throw new \Exception('Gagal auth API');
            }

            return $response->json()['access_token'];
        });
    }

    public function getMedicines()
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->get($this->baseUrl . '/medicines');

        return $response->json()['medicines'];
    }

    public function getPrices($medicineId)
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->get($this->baseUrl . "/medicines/{$medicineId}/prices");

        return $response->json();
    }
}