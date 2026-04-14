@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-family: 'Roboto', sans-serif; font-weight: 500;">Detail Pemeriksaan</h3>
        @if(auth()->user()->role === 'dokter')
            <a href="/doctor/dashboard" class="btn btn-outline-secondary px-4" style="border-radius: 8px;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @elseif (auth()->user()->role === 'apoteker')
            <a href="/pharmacist/dashboard" class="btn btn-outline-secondary px-4" style="border-radius: 8px;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
        <div class="p-4 bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-bold">{{ $item->nama_pasien }}</h4>
                <small class="opacity-75">ID Pemeriksaan: #{{ $item->id }}</small>
            </div>
            <div class="text-end">
                <div class="fw-bold">{{ date('d M Y', strtotime($item->waktu_pemeriksaan)) }}</div>
                <small class="opacity-75">{{ date('H:i', strtotime($item->waktu_pemeriksaan)) }} WIB</small>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="row g-0 border-bottom">
                <div class="col-md-3 bg-light p-3 fw-bold border-end text-secondary" style="font-size: 0.85rem;">TANDA VITAL</div>
                <div class="col-md-9 p-3">
                    <div class="d-flex flex-wrap gap-3">
                        <span><i class="fas fa-arrows-alt-v text-primary me-1"></i> {{ $item->tinggi_badan }} cm</span>
                        <span><i class="fas fa-weight text-primary me-1"></i> {{ $item->berat_badan }} kg</span>
                        <span><i class="fas fa-thermometer-half text-warning me-1"></i> {{ $item->suhu }}°C</span>
                        <span><i class="fas fa-heartbeat text-danger me-1"></i> {{ $item->systole }}/{{ $item->diastole }} mmHg</span>
                        <span><i class="fas fa-wind text-info me-1"></i> {{ $item->respiration_rate }} x/mnt</span>
                    </div>
                </div>
            </div>

            <div class="row g-0 border-bottom">
                <div class="col-md-3 bg-light p-3 fw-bold border-end text-secondary" style="font-size: 0.85rem;">DIAGNOSA & CATATAN</div>
                <div class="col-md-9 p-3">
                    <p class="mb-0 text-dark" style="line-height: 1.6;">{{ $item->catatan }}</p>
                </div>
            </div>

            <div class="row g-0 border-bottom">
                <div class="col-md-3 bg-light p-3 fw-bold border-end text-secondary" style="font-size: 0.85rem;">BERKAS PEMERIKSAAN</div>
                <div class="col-md-9 p-3">
                    @if($item->berkas_pemeriksaan)
                        @if(auth()->user()->role === 'dokter')
                            <a href="/doctor/download-berkas/{{ $item->id }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file-download me-2"></i> Lihat Berkas Lampiran
                            </a>
                        @else
                            <a href="/pharmacist/download-berkas/{{ $item->id }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file-download me-2"></i> Lihat Berkas Lampiran
                            </a>
                        @endif
                    @else
                        <span class="text-muted small italic">Tidak ada berkas yang diunggah</span>
                    @endif
                </div>
            </div>

            <div class="row g-0">
                <div class="col-md-3 bg-light p-3 fw-bold border-end text-secondary" style="font-size: 0.85rem;">RESEP OBAT</div>
                <div class="col-md-9 p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3 border-0" style="font-size: 0.75rem;">NAMA OBAT</th>
                                <th class="border-0" style="font-size: 0.75rem;">QTY</th>
                                <th class="border-0 text-end pe-3" style="font-size: 0.75rem;">HARGA SATUAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->prescription->items as $med)
                            <tr>
                                <td class="ps-3">{{ $med->medicine_name }}</td>
                                <td>{{ $med->qty }}</td>
                                <td class="text-end pe-3">Rp {{ number_format($med->price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        @if(auth()->user()->role === 'apoteker')
        <a href="/pharmacist/print/{{ $item->id }}" class="btn btn-secondary px-4">
            <i class="fas fa-print me-2"></i> Cetak Hasil
        </a>
        @endif
        
        @if(!$item->prescription->is_served && auth()->user()->role === 'dokter')
        <a href="/doctor/edit/{{ $item->id }}" class="btn btn-warning px-4 fw-bold">
            <i class="fas fa-edit me-2"></i> Edit Data
        </a>
        @endif
    </div>
</div>
@endsection