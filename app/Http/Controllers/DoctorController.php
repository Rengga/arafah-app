<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examination;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;


class DoctorController extends Controller
{
    public function index()
    {
        $data = Examination::with('prescription.items')
                ->where('doctor_id', auth()->id())
                ->latest()
                ->get();

        return view('doctor.history', compact('data'));
    }

    public function form()
    {
        return view('doctor.form');
    }
    
    public function detail($id)
    {
        $item = Examination::with(['prescription.items', 'doctor']) 
                ->findOrFail($id);

        return view('detail', compact('item'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255', 
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'systole' => 'required|integer',
            'diastole' => 'required|integer', 
            'catatan' => 'required|string', 
            'berkas_pemeriksaan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', 
            'medicines' => 'required|array', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return DB::transaction(function () use ($request) {
           
            $filePath = null;
            if ($request->hasFile('berkas_pemeriksaan')) {
               
                $filePath = $request->file('berkas_pemeriksaan')->store('pemeriksaan', 'public');
            }

        
            $exam = Examination::create([
                'doctor_id' => auth()->id(),
                'nama_pasien' => $request->nama_pasien,
                'berkas_pemeriksaan' => $filePath,
                'waktu_pemeriksaan' => now(),
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'systole' => $request->systole,
                'diastole' => $request->diastole,
                'heart_rate' => $request->heart_rate,
                'respiration_rate' => $request->respiration_rate,
                'suhu' => $request->suhu,
                'catatan' => $request->catatan, 
            ]);

            $prescription = Prescription::create([
                'examination_id' => $exam->id
            ]);

            foreach ($request->medicines as $med) {
                $cleanPrice = str_replace('.', '', $med['price']);
            
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $med['id'] ?? '',
                    'medicine_name' => $med['name'] ?? 'Tidak diketahui',
                    'qty' => $med['qty'] ?? 0,
                    'price' => (int) $cleanPrice,
                ]);
            }

            return response()->json(['message' => 'Berhasil disimpan']);
        });
    }

    public function update($id, Request $request)
    {
        $prescription = Prescription::with('examination')->findOrFail($id);

        if ($prescription->is_served) {
            return response()->json(['message' => 'Data tidak bisa diubah karena sudah dilayani apoteker'], 400);
        }

        return DB::transaction(function () use ($prescription, $request) {
            
            $exam = $prescription->examination;
            
            $filePath = $exam->berkas_pemeriksaan;
            if ($request->hasFile('berkas_pemeriksaan')) {
                if ($filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('berkas_pemeriksaan')->store('pemeriksaan', 'public');
            }

            $exam->update([
                'nama_pasien' => $request->nama_pasien,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'systole' => $request->systole,
                'diastole' => $request->diastole,
                'heart_rate' => $request->heart_rate,
                'respiration_rate' => $request->respiration_rate,
                'suhu' => $request->suhu,
                'catatan' => $request->catatan,
                'berkas_pemeriksaan' => $filePath,
            ]);

            
            $prescription->items()->delete();

            foreach ($request->medicines as $med) {
                $cleanPrice = str_replace('.', '', $med['price']);

                \App\Models\PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $med['id'],
                    'medicine_name' => $med['name'],
                    'qty' => $med['qty'],
                    'price' => (int) $cleanPrice,
                ]);
            }

            return response()->json(['message' => 'Data pemeriksaan dan resep berhasil diperbarui']);
        });
    }

    public function edit($id){   
        $examination = \App\Models\Examination::with('prescription.items')->findOrFail($id);

        return view('doctor.form', compact('examination'));
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