@extends('layouts.app')

@section('content')

<style>
    body { background-color: #f4f6f9; }
    .table thead th { border-bottom: 1px solid #edf2f9; }
    tr:hover { background-color: #fcfdfe; transition: background-color 0.2s ease; }
    .badge { font-size: 0.7rem; letter-spacing: 0.5px; }
    .btn-primary { background-color: #1976d2; border: none; }
    .btn-primary:hover { background-color: #1565c0; transform: translateY(-1px); }
    .text-patient { font-weight: 600; color: #2c3e50; }
    .text-date { font-size: 0.8rem; color: #7f8c8d; }
    .medicine-inline { font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px; }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 style="font-family: 'Roboto', sans-serif; font-weight: 500;" class="mb-0">Dashboard Apoteker</h3>
            <p class="text-muted small">Manajemen antrian resep obat pasien</p>
        </div>
        <span class="badge bg-white shadow-sm text-dark p-2 px-3" style="border-radius: 10px;">
            Total Antrian: <span class="text-primary fw-bold">{{ count($data) }}</span>
        </span>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="background-color: white;">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">Pasien & Tanggal</th>
                        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">Dokter</th>
                        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 600;">Detail Obat</th>
                        <th class="py-3 text-uppercase text-secondary text-center" style="font-size: 0.75rem; font-weight: 600;">Status</th>
                        <th class="py-3 text-uppercase text-secondary text-center" style="font-size: 0.75rem; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $item)
                    @php 
                        $prescription = $item->prescription;
                        $itemsCount = $prescription ? $prescription->items->count() : 0;
                        $isServed = $prescription->is_served ?? false;
                    @endphp
                    <tr class="border-bottom">
                        <td class="ps-4">
                            <div class="d-flex flex-column">
                                <span class="text-patient">{{ $item->nama_pasien }}</span>
                                <span class="text-date">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="small fw-medium"><i class="fas fa-user-md text-primary me-1"></i> {{ $item->doctor->name ?? 'Dokter' }}</span>
                        </td>
                        <td class="py-3">
                            <div class="medicine-inline">
                                @if($itemsCount > 0)
                                    <span class="fw-bold text-dark">{{ $prescription->items[0]->medicine_name }}</span>
                                    @if($itemsCount > 1)
                                        <span class="badge bg-info text-white ms-1" style="font-size: 0.65rem;">+{{ $itemsCount - 1 }} obat lainnya</span>
                                    @endif
                                @else
                                    <span class="text-muted small">Tidak ada resep</span>
                                @endif
                            </div>
                        </td>

                        <td class="status-column text-center">
                            @if($isServed)
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
                                <a href="/pharmacist/detail/{{ $item->id }}" class="btn btn-sm px-3" 
                                    style="background-color: #e3f2fd; color: #1976d2; border: 1px solid #bbdefb; border-radius: 8px; font-weight: 600;">
                                     <i class="fas fa-eye"></i>
                                 </a>

                                @if(!$isServed && $prescription)
                                    <button class="btn btn-primary btn-sm px-3 shadow-sm btn-serve"
                                        data-id="{{ $prescription->id }}"
                                        style="border-radius: 8px; font-weight: 500;">
                                        LAYANI
                                    </button>
                                @endif

                                <a href="/pharmacist/print/{{ $item->id }}" class="btn btn-outline-secondary btn-sm px-2" style="border-radius: 8px;">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-prescription text-primary me-2"></i>Detail Resep</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 p-3 bg-light" style="border-radius: 10px;">
                    <div class="small text-muted">Pasien: <strong id="detName" class="text-dark"></strong></div>
                    <div class="small text-muted">Dokter: <strong id="detDoctor" class="text-dark"></strong></div>
                </div>
                <h6 class="fw-bold mb-3 small text-secondary text-uppercase">Daftar Obat:</h6>
                <div id="medicineListDetail">
                    </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary w-100" style="border-radius: 10px;" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetail(nama, dokter, itemsJson) {
        const items = JSON.parse(itemsJson);
        document.getElementById('detName').innerText = nama;
        document.getElementById('detDoctor').innerText = dokter;
        
        let html = '<ul class="list-group list-group-flush">';
        items.forEach(med => {
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <i class="fas fa-pills text-muted me-2"></i><strong>${med.medicine_name}</strong>
                    </div>
                    <span class="badge bg-primary rounded-pill">${med.qty} pcs</span>
                </li>`;
        });
        html += '</ul>';
        
        document.getElementById('medicineListDetail').innerHTML = items.length > 0 ? html : '<p class="text-muted italic">Tidak ada resep.</p>';
        new bootstrap.Modal(document.getElementById('modalDetail')).show();
    }

    document.addEventListener('click', async function(e) {
        const button = e.target.closest('.btn-serve');
        if (!button) return;

        const id = button.dataset.id;

        const result = await Swal.fire({
            title: "Konfirmasi",
            text: "Yakin mau melayani resep ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, layani!",
            cancelButtonText: "Batal",
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-primary px-4 py-2 mx-2',
                cancelButton: 'btn btn-outline-secondary px-4 py-2 mx-2'
            },
            buttonsStyling: false
        });

        if (!result.isConfirmed) return;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            button.disabled = true;
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            const res = await fetch(`/pharmacist/serve/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });

            if (res.ok) {
                await Swal.fire({
                    title: "Berhasil!",
                    text: "Resep berhasil dilayani.",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                location.reload(); 
            } else {
                const data = await res.json();
                throw new Error(data.message || 'Gagal memproses resep.');
            }
        } catch (err) {
            console.error(err);
            Swal.fire({
                title: "Gagal!",
                text: err.message || 'Terjadi kesalahan jaringan!',
                icon: "error"
            });
            
            button.disabled = false;
            button.innerHTML = 'LAYANI';
        }
    });
</script>

@endsection