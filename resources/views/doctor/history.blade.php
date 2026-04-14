@extends('layouts.app')

@section('content')
    <h3 class="mb-4" style="font-family: 'Roboto', sans-serif; font-weight: 500;">Riwayat Pemeriksaan Pasien</h3>
    <div class="w-100 justify-content-end d-flex mb-2">
        <a href="/doctor/form" class="btn btn-primary shadow-sm px-4" style="border-radius: 8px; font-weight: 500;">
            <i class="fas fa-plus me-2"></i> Tambah Pemeriksaan Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">ID</th>
                        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">Pasien</th> {{-- Kolom Baru --}}
                        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">Tanggal</th> {{-- Header Diganti --}}
                        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">Detail Vital</th>
                        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">Status Resep</th>
                        <th class="py-3 text-uppercase text-secondary text-center" style="font-size: 0.75rem; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr class="border-bottom">
                        <td class="ps-4">
                            <span class="fw-bold text-primary">#{{ $item->id }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->nama_pasien ?? 'Tidak Ada Nama' }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.9rem; font-weight: 500;">
                                {{ date('d M Y', strtotime($item->waktu_pemeriksaan)) }}
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ date('H:i', strtotime($item->waktu_pemeriksaan)) }} WIB
                            </small>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border" style="font-weight: 500;">
                                    <i class="fas fa-heartbeat text-danger me-1"></i> {{ $item->systole }}/{{ $item->diastole }}
                                </span>
                                <span class="badge bg-light text-dark border" style="font-weight: 500;">
                                    <i class="fas fa-thermometer-half text-warning me-1"></i> {{ $item->suhu }}°C
                                </span>
                                <span class="badge bg-light text-dark border" style="font-weight: 500;">
                                    <i class="fas fa-weight me-1"></i> {{ $item->berat_badan }}kg
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($item->prescription && $item->prescription->is_served)
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #e8f5e9; color: #2e7d32; font-weight: 600;">
                                    <i class="fas fa-check-circle me-1"></i> SELESAI
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #fff3e0; color: #ef6c00; font-weight: 600;">
                                    <i class="fas fa-clock me-1"></i> PENDING
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/doctor/detail/{{ $item->id }}" class="btn btn-sm px-3" 
                                    style="background-color: #e3f2fd; color: #1976d2; border: 1px solid #bbdefb; border-radius: 8px; font-weight: 600;">
                                     <i class="fas fa-eye"></i>
                                 </a>
                                @if($item->prescription && !$item->prescription->is_served)
                                    <a href="/doctor/edit/{{ $item->id }}" class="btn btn-sm px-3" 
                                       style="background-color: #fff8e1; color: #f57c00; border: 1px solid #ffe0b2; border-radius: 8px; font-weight: 600;">
                                        <i class="fas fa-edit me-1"></i> EDIT
                                    </a>
                                @else
                                    <button class="btn btn-sm px-3 disabled" 
                                            style="background-color: #f5f5f5; color: #9e9e9e; border: 1px solid #e0e0e0; border-radius: 8px; cursor: not-allowed;">
                                        <i class="fas fa-lock me-1"></i> LOCKED
                                    </button>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection