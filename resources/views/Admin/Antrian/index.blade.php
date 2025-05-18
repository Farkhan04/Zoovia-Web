@extends('layouts.app')

@section('title', 'Kelola Antrian')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold"><i class="bx bx-group me-2 text-primary"></i>Kelola Antrian</h4>
        <div>
            <a href="{{ route('admin.antrian.callnext') }}" class="btn btn-success">
                <i class="bx bx-user-voice me-1"></i> Panggil Antrian
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Search & Filter Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.antrian.index') }}" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $date ?? now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-filter-alt me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Antrian -->
<div class="row mb-4">
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Total Antrian</h5>
                        <h2 class="fw-bold mb-0" id="total-antrian">{{ $summary->total ?? 0 }}</h2>
                    </div>
                    <div class="avatar bg-label-primary p-2">
                        <i class="bx bx-list-ul"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Menunggu</h5>
                        <h2 class="fw-bold mb-0 text-warning" id="waiting-antrian">{{ $summary->waiting ?? 0 }}</h2>
                    </div>
                    <div class="avatar bg-label-warning p-2">
                        <i class="bx bx-time-five"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Diproses</h5>
                        <h2 class="fw-bold mb-0 text-info" id="processing-antrian">{{ $summary->processing ?? 0 }}</h2>
                    </div>
                    <div class="avatar bg-label-info p-2">
                        <i class="bx bx-loader"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Selesai</h5>
                        <h2 class="fw-bold mb-0 text-success" id="completed-antrian">{{ $summary->completed ?? 0 }}</h2>
                    </div>
                    <div class="avatar bg-label-success p-2">
                        <i class="bx bx-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Antrian Saat Ini -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="m-0 me-2 card-title">Antrian Saat Ini</h5>
            </div>
            <div class="card-body text-center">
                @if($currentQueue)
                    <div class="current-queue-container">
                        <h1 class="display-1 fw-bold text-primary" id="current-number">{{ $currentQueue->nomor_antrian }}</h1>
                        <h5 class="mb-3" id="current-name">{{ $currentQueue->nama }}</h5>
                        <div class="badge bg-info fs-6 mb-3">Sedang Diproses</div>
                        <p><strong>Layanan:</strong> <span id="current-service">{{ $currentQueue->layanan->nama_layanan }}</span></p>
                    </div>
                @else
                    <div class="py-4 text-muted">
                        <i class="bx bx-info-circle fs-1"></i>
                        <h5 class="mt-2">Tidak ada antrian yang sedang diproses</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="m-0 me-2 card-title">Antrian Berikutnya</h5>
            </div>
            <div class="card-body text-center">
                @if($nextQueue)
                    <div class="next-queue-container">
                        <h1 class="display-1 fw-bold text-warning" id="next-number">{{ $nextQueue->nomor_antrian }}</h1>
                        <h5 class="mb-3" id="next-name">{{ $nextQueue->nama }}</h5>
                        <div class="badge bg-label-warning fs-6 mb-3">Menunggu</div>
                        <p><strong>Layanan:</strong> <span id="next-service">{{ $nextQueue->layanan->nama_layanan }}</span></p>
                    </div>
                @else
                    <div class="py-4 text-muted">
                        <i class="bx bx-info-circle fs-1"></i>
                        <h5 class="mt-2">Tidak ada antrian yang menunggu</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Daftar Antrian Table Card -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Antrian</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No.</th>
                        <th width="10%">Nomor Antrian</th>
                        <th width="20%">Nama Pelanggan</th>
                        <th width="15%">Nama Hewan</th>
                        <th width="15%">Layanan</th>
                        <th width="15%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="antrian-table-body">
                    @if(count($antrian) > 0)
                        @foreach($antrian as $index => $item)
                            <tr data-id="{{ $item->id }}" class="antrian-row">
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $item->nomor_antrian }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <div class="avatar-initial rounded-circle bg-label-primary">
                                                {{ substr($item->user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-nowrap">{{ $item->user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->hewan->nama_hewan }}</td>
                                <td>{{ $item->layanan->nama_layanan }}</td>
                                <td>
                                    @if($item->status == 'menunggu')
                                        <span class="badge bg-label-warning">Menunggu</span>
                                    @elseif($item->status == 'diproses')
                                        <span class="badge bg-label-info">Diproses</span>
                                    @else
                                        <span class="badge bg-label-success">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.antrian.show', $item->id) }}" class="btn btn-icon btn-sm btn-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if($item->status == 'menunggu')
                                            <a href="{{ route('admin.antrian.confirm', $item->id) }}" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi">
                                                <i class="bx bx-check-square"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center py-3">Tidak ada data antrian</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination if needed -->
        @if(isset($antrian) && method_exists($antrian, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $antrian->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .expandable-row {
        display: none;
    }
    
    .toggle-icon {
        transition: transform 0.3s ease;
    }
    
    .toggle-icon.rotate {
        transform: rotate(180deg);
    }
    
    .bg-light-primary {
        background-color: rgba(105, 108, 255, 0.08);
    }
    
    .badge.bg-label-warning {
        background-color: rgba(255, 171, 0, 0.16) !important;
        color: #ffab00;
    }
    
    .badge.bg-label-success {
        background-color: rgba(40, 199, 111, 0.16) !important;
        color: #28c76f;
    }
    
    .badge.bg-label-info {
        background-color: rgba(0, 207, 232, 0.16) !important;
        color: #00cfea;
    }
    
    .badge.bg-label-primary {
        background-color: rgba(105, 108, 255, 0.16) !important;
        color: #696cff;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Konfigurasi Pusher
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            encrypted: true
        });
        
        // Subscribe ke channel 'antrian'
        var channel = pusher.subscribe('antrian');
        
        // Listener untuk event AntrianUpdated
        channel.bind('App\\Events\\AntrianUpdated', function(data) {
            // Update data statistik
            updateQueueStatistics(data.queueSummary);
            
            // Update antrian saat ini dan berikutnya
            updateCurrentQueues(data);
            
            // Refresh daftar antrian jika perlu
            if (data.action === 'create' || data.action === 'update-status') {
                refreshQueueList();
            }
            
            // Notifikasi toast
            if (data.action === 'create') {
                showToast('success', 'Antrian baru telah ditambahkan.');
            } else if (data.action === 'update-status') {
                showToast('info', 'Status antrian telah diperbarui.');
            }
        });
        
        // Fungsi untuk update statistik antrian
        function updateQueueStatistics(summary) {
            $('#total-antrian').text(summary.total || 0);
            $('#waiting-antrian').text(summary.waiting || 0);
            $('#processing-antrian').text(summary.processing || 0);
            $('#completed-antrian').text(summary.completed || 0);
        }
        
        // Fungsi untuk update antrian saat ini dan berikutnya
        function updateCurrentQueues(data) {
            // Update antrian yang sedang diproses
            if (data.queueSummary.current_number > 0) {
                $('.current-queue-container').removeClass('d-none');
                $('#current-number').text(data.queueSummary.current_number);
                
                // Cari data antrian yang sedang diproses
                if (data.action === 'update-status' && data.antrian.status === 'diproses') {
                    $('#current-name').text(data.antrian.nama);
                    $('#current-service').text(data.antrian.layanan.nama_layanan);
                }
            } else {
                $('.current-queue-container').addClass('d-none');
            }
            
            // Update antrian berikutnya
            if (data.queueSummary.next_number > 0) {
                $('.next-queue-container').removeClass('d-none');
                $('#next-number').text(data.queueSummary.next_number);
                
                // Cek jika antrian yang sedang diproses sekarang adalah yang sebelumnya menunggu
                if (data.action === 'update-status' && data.antrian.status === 'diproses') {
                    // Kita perlu mengupdate UI dengan antrian menunggu berikutnya
                    refreshQueueList();
                }
            } else {
                $('.next-queue-container').addClass('d-none');
            }
        }
        
        // Fungsi untuk refresh daftar antrian
        function refreshQueueList() {
            // Gunakan AJAX untuk memuat ulang daftar antrian
            $.ajax({
                url: window.location.href,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    var newHtml = $(response).find('#antrian-table-body').html();
                    $('#antrian-table-body').html(newHtml);
                }
            });
        }
        
        // Fungsi untuk menampilkan toast
        function showToast(type, message) {
            var bgClass = type === 'success' ? 'bg-success' : type === 'info' ? 'bg-info' : 'bg-danger';
            var icon = type === 'success' ? 'bx-check' : type === 'info' ? 'bx-info-circle' : 'bx-error';
            
            var toast = `
                <div class="bs-toast toast toast-placement-ex m-2 ${bgClass} top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="bx ${icon} me-2"></i>
                        <div class="me-auto fw-semibold">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>
            `;
            
            $('body').append(toast);
            
            setTimeout(function() {
                $('.bs-toast').toast('hide');
            }, 3000);
        }
    });
</script>
@endpush