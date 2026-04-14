<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MedicineService;

class MedicineController extends Controller
{
     public function index(MedicineService $service)
    {
        $medicines = $service->getMedicines();
        return response()->json($medicines);
    }

    public function prices($id, MedicineService $service)
    {
        $prices = $service->getPrices($id);
        return response()->json($prices);
    }
}