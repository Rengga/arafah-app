@extends('layouts.app')

@section('content')

@php
    $isEdit = isset($examination);
    $title = $isEdit ? 'Edit Pemeriksaan Pasien' : 'Dashboard Dokter';
    $actionUrl = $isEdit ? '/doctor/update/' . $examination->prescription->id : '/doctor/exam';
    $buttonText = $isEdit ? 'UPDATE PEMERIKSAAN' : 'SIMPAN PEMERIKSAAN';
    $buttonColor = $isEdit ? '#2e7d32' : '#1976d2'; 
@endphp

<style>
    body { background-color: #f8f9fa; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #dee2e6; }
    .form-control:focus, .form-select:focus { border-color: #1976d2; box-shadow: none; }
    .btn-outline-danger:hover { background-color: #fff1f0; color: #d32f2f; }
    .animate__animated { animation-duration: 0.3s; }
    
    .file-upload-wrapper {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
        transition: all 0.3s;
    }
    .file-upload-wrapper:hover { border-color: #1976d2; background: #f0f7ff; }

    @keyframes shimmer {
        0% { background-position: -468px 0; }
        100% { background-position: 468px 0; }
    }

    .loading-field {
        animation: shimmer 1.2s infinite linear;
        background: #f6f7f8;
        background-image: linear-gradient(to right, #f6f7f8 0%, #c1e1ff 20%, #f6f7f8 40%, #f6f7f8 100%);
        background-repeat: no-repeat;
        background-size: 800px 104px;
        color: transparent !important;
        pointer-events: none;
    }

    .form-control:disabled {
        background-color: #eaf8ff;
        cursor: not-allowed;
        opacity: 0.7;
    }
</style>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-family: 'Roboto', sans-serif; font-weight: 500;">{{ $title }}</h3>
        <a href="/doctor/dashboard" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-history me-1"></i> Lihat Riwayat
        </a>
    </div>

    <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
        <form id="formExam" enctype="multipart/form-data">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <h5 class="mb-3 text-primary" style="font-weight: 600;"><i class="fas fa-user-circle me-2"></i>Data Pasien & Vital Sign</h5>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="nama_pasien" class="form-control fw-bold" placeholder="Nama Pasien" value="{{ $examination->nama_pasien ?? '' }}" required>
                        <label>Nama Pasien</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="file-upload-wrapper">
                        <label class="small text-muted mb-1 d-block">
                            <i class="fas fa-paperclip me-1"></i> 
                            {{ $isEdit ? 'Update Berkas (Kosongkan jika tidak diubah)' : 'Upload Berkas Luar (PDF/Gambar)' }}
                        </label>
                        <input type="file" name="berkas_pemeriksaan" class="form-control form-control-sm">
                        
                        @if($isEdit && $examination->berkas_pemeriksaan)
                            <small class="text-primary mt-1 d-block">File saat ini: <a href="/doctor/download-berkas/{{ $examination->id }}" target="_blank">Lihat Berkas</a></small>
                        @endif
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="number" name="tinggi_badan" class="form-control" placeholder="170" value="{{ $examination->tinggi_badan ?? '' }}" required>
                        <label>Tinggi Badan (cm)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="number" name="berat_badan" class="form-control" placeholder="60" value="{{ $examination->berat_badan ?? '' }}" required>
                        <label>Berat Badan (kg)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="number" step="0.1" name="suhu" class="form-control" placeholder="36.5" value="{{ $examination->suhu ?? '' }}" required>
                        <label>Suhu Tubuh (°C)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="number" name="heart_rate" class="form-control" placeholder="80" value="{{ $examination->heart_rate ?? '' }}" required>
                        <label>Heart Rate (bpm)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="number" name="systole" class="form-control" placeholder="120" value="{{ $examination->systole ?? '' }}" required>
                        <label>Systole (mmHg)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="number" name="diastole" class="form-control" placeholder="80" value="{{ $examination->diastole ?? '' }}" required>
                        <label>Diastole (mmHg)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="number" name="respiration_rate" class="form-control" placeholder="20" value="{{ $examination->respiration_rate ?? '' }}" required>
                        <label>Respiration Rate (x/mnt)</label>
                    </div>
                </div>
            </div>

            <h5 class="mb-3 text-primary" style="font-weight: 600;"><i class="fas fa-stethoscope me-2"></i>Hasil Pemeriksaan & Diagnosa</h5>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea name="catatan" class="form-control" style="height: 120px" placeholder="Tulis diagnosa..." required>{{ $examination->catatan ?? '' }}</textarea>
                        <label>Diagnosa / Catatan Bebas Dokter</label>
                    </div>
                </div>
            </div>
            
            <hr class="my-4" style="opacity: 0.1;">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="font-weight: 600; color: #1976d2;"><i class="fas fa-pills me-2"></i>Resep Obat</h5>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="addMedicine()">
                    <i class="fas fa-plus me-1"></i> Tambah Obat
                </button>
            </div>

            <div id="medicine-list">
                @if($isEdit && $examination->prescription && $examination->prescription->items->count() > 0)
                    @foreach($examination->prescription->items as $i => $item)
                    <div class="row g-2 mb-3 align-items-center medicine-row">
                        <div class="col-md-5">
                            <div class="form-floating">
                                <select name="medicines[{{ $i }}][id]" class="form-select medicine-select" required data-selected="{{ $item->medicine_id }}">
                                    <option value="">Pilih Obat...</option>
                                </select>
                                <input type="hidden" name="medicines[{{ $i }}][name]" value="{{ $item->medicine_name }}" class="medicine-name-hidden">
                                <label>Nama Obat</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="number" name="medicines[{{ $i }}][qty]" class="form-control" value="{{ $item->qty }}" required>
                                <label>Qty</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="medicines[{{ $i }}][price]" class="form-control price-input" value="{{ number_format($item->price, 0, ',', '.') }}" required>
                                <label>Harga Satuan</label>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-outline-danger border-0" onclick="removeMedicine(this)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="row g-2 mb-3 align-items-center medicine-row">
                        <div class="col-md-5">
                            <div class="form-floating">
                                <select name="medicines[0][id]" class="form-select medicine-select" required>
                                    <option value="">Pilih Obat...</option>
                                </select>
                                <input type="hidden" name="medicines[0][name]" class="medicine-name-hidden">
                                <label>Nama Obat</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="number" name="medicines[0][qty]" class="form-control" placeholder="Qty" required>
                                <label>Qty</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="medicines[0][price]" class="form-control price-input" placeholder="0" disabled required>
                                <label>Harga Satuan</label>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-light text-muted" disabled><i class="fas fa-lock"></i></button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" id="btnSimpan" class="btn btn-primary px-5 py-3 shadow" 
                    style="border-radius: 12px; font-weight: 600; background-color: {{ $buttonColor }}; border: none;">
                    <i class="fas fa-save me-2"></i> {{ $buttonText }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Ambil jumlah item (penting untuk edit)
    let index = {{ ($isEdit && $examination->prescription) ? count($examination->prescription->items) : 1 }};
    let medicineDataCache = [];
    
    // Inisialisasi: Load daftar obat
    async function loadMedicines() {
        console.log("Memulai loadMedicines..."); // Debugging
        try {
            // Gunakan url() helper agar path selalu benar
            const res = await fetch("{{ url('/medicines') }}", {
                headers: { 'Accept': 'application/json' }
            });

            const data = await res.json();
            console.log("Data mentah dari server:", data);

            // PERBAIKAN: API membungkus data di dalam properti 'medicines'
            // Kita pastikan medicineDataCache selalu berupa Array
            medicineDataCache = data.medicines || data; 

            // Isi semua select yang sudah ada
            document.querySelectorAll('.medicine-select').forEach(select => {
                populateSelect(select);
                
                const selectedId = select.getAttribute('data-selected');
                if (selectedId) {
                    select.value = selectedId;
                }
            });
            console.log("Daftar obat berhasil dimuat ke Select.");

        } catch (e) {
            console.error("Gagal memuat data obat:", e);
        }
    }
    
    function populateSelect(selectElement) {
        selectElement.innerHTML = '<option value="">Pilih Obat...</option>';
        
        // Pastikan medicineDataCache adalah array sebelum di-loop
        if (Array.isArray(medicineDataCache)) {
            medicineDataCache.forEach(med => {
                let opt = document.createElement('option');
                opt.value = med.id;
                opt.text = med.name;
                selectElement.appendChild(opt);
            });
        }
    }
    
    function addMedicine() {
        const medicineList = document.getElementById('medicine-list');
        let html = `
        <div class="row g-2 mb-3 align-items-center medicine-row animate__animated animate__slideInDown">
            <div class="col-md-5">
                <div class="form-floating">
                    <select name="medicines[${index}][id]" class="form-select medicine-select" required>
                        <option value="">Pilih Obat...</option>
                    </select>
                    <input type="hidden" name="medicines[${index}][name]" class="medicine-name-hidden">
                    <label>Nama Obat</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating">
                    <input type="number" name="medicines[${index}][qty]" class="form-control" placeholder="Qty" required>
                    <label>Qty</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" name="medicines[${index}][price]" class="form-control price-input" placeholder="0" disabled required>
                    <label>Harga Satuan</label>
                </div>
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-outline-danger border-0" onclick="removeMedicine(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>`;
        
        medicineList.insertAdjacentHTML('beforeend', html);
        populateSelect(medicineList.lastElementChild.querySelector('.medicine-select'));
        index++;
    }

    // Handle perubahan obat
    document.addEventListener('change', async function(e) {
        if (e.target.classList.contains('medicine-select')) {
            const id = e.target.value;
            const row = e.target.closest('.medicine-row');
            const priceInput = row.querySelector('.price-input');
            const nameHidden = row.querySelector('.medicine-name-hidden');

            if (nameHidden) nameHidden.value = e.target.options[e.target.selectedIndex].text;

            if (id) {
                try {
                    priceInput.classList.add('loading-field');
                    // Tambahkan URL helper
                    const res = await fetch(`{{ url('/medicines') }}/${id}/prices`);
                    const data = await res.json();
                    
                    // Sesuaikan dengan struktur response harga API kamu
                    let rawPrice = (data.prices && data.prices.length > 0) ? data.prices[0].unit_price : 0;
                    
                    priceInput.classList.remove('loading-field');
                    priceInput.disabled = false;
                    priceInput.value = new Intl.NumberFormat('id-ID').format(rawPrice);
                } catch (error) { 
                    priceInput.classList.remove('loading-field');
                    priceInput.disabled = false; // Tetap aktifkan agar bisa isi manual jika API gagal
                }
            }
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('price-input')) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value) e.target.value = new Intl.NumberFormat('id-ID').format(value);
        }
    });

    function removeMedicine(button) {
        const row = button.closest('.medicine-row');
        if (document.querySelectorAll('.medicine-row').length > 1) {
            row.remove();
        }
    }

    document.getElementById('formExam').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSimpan');
        btn.disabled = true;
        
        // Bersihkan titik sebelum kirim
        document.querySelectorAll('.price-input').forEach(input => {
            input.value = input.value.replace(/\./g, '');
        });

        const formData = new FormData(this);
        @if($isEdit) formData.append('_method', 'PUT'); @endif

        try {
            const res = await fetch('{{ $actionUrl }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (res.ok) {
                alert('Berhasil!');
                window.location.href = '/doctor/dashboard';
            } else {
                const errData = await res.json();
                alert('Gagal: ' + (errData.message || 'Cek kembali data'));
            }
        } catch (err) {
            alert('Kesalahan jaringan!');
        } finally {
            btn.disabled = false;
        }
    });

    // Jalankan inisialisasi
    loadMedicines();
</script>
@endsection