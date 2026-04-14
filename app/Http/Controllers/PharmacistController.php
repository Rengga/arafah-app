<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Examination;
use Illuminate\Support\Facades\Storage;

class PharmacistController extends Controller
{
    public function index()
    {
        $data = Examination::has('prescription')
                ->with(['prescription.items', 'doctor'])
                ->latest()
                ->get();

        return view('pharmacist.dashboard', compact('data'));
    }

    public function detail($id)
    {
        $item = Examination::with(['prescription.items', 'doctor']) 
                ->findOrFail($id);

        return view('detail', compact('item'));
    }

    public function serve($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->update([
            'is_served' => true
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Resep sudah dilayani'
        ]);
    }

    public function print($id)
    {
        $data = Prescription::with('items')->find($id);

        $pdf = Pdf::loadView('pdf.receipt', compact('data'));

        return $pdf->download('resi.pdf');
    }

    public function downloadBerkas($id)
    {
        $exam = Examination::findOrFail($id);

        if (!$exam->berkas_pemeriksaan || !Storage::disk('public')->exists($exam->berkas_pemeriksaan)) {
            return back()->with('error', 'Berkas tidak ditemukan.');
        }

        $extension = pathinfo($exam->berkas_pemeriksaan, PATHINFO_EXTENSION);
        $fileName = 'Berkas_' . str_replace(' ', '_', $exam->nama_pasien) . '.' . $extension;

        return Storage::disk('public')->download($exam->berkas_pemeriksaan, $fileName);
    }
}