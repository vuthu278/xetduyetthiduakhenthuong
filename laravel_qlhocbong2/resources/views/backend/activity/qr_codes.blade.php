@extends('backend.layouts.backend_master')
@section('content')
<div class="container-fluid px-4">
    @if (session('success'))
    <div id="flash-alert" class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">QR Code điểm danh</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('backend.activity.index') }}">Hoạt động</a></li>
                    <li class="breadcrumb-item active">{{ $activity->name }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('backend.activity.index') }}" class="btn btn-outline-secondary">Trở về</a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Tạo mã QR mới</h5>
            <form action="{{ route('backend.activity.generate_qr', ['id' => (string)($activityIdStr ?? '')]) }}" method="POST" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Loại QR</label>
                    <select name="type" class="form-select">
                        <option value="1">QR Vào (check-in)</option>
                        <option value="2">QR Ra (check-out)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Thời hạn (phút)</label>
                    <input type="number" name="valid_minutes" class="form-control" value="5" min="1" max="1440">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tạo QR</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Danh sách mã QR đã tạo</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>STT</th>
                            <th>Loại</th>
                            <th>Hết hạn lúc</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activity->qrCodes ?? [] as $key => $qr)
                        @php
                            $qrIdStr = is_object($qr) && method_exists($qr, 'getRouteKey') ? (string) $qr->getRouteKey() : (string) mongodb_id_string(is_object($qr) ? $qr->_id : ($qr['_id'] ?? ''));
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><span class="badge bg-{{ $qr->type == 1 ? 'success' : 'info' }}">{{ \App\Models\ActivityQrCode::typeLabel($qr->type) }}</span></td>
                            <td>{{ $qr->expires_at ? $qr->expires_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('backend.activity.show_qr', ['id' => (string)($activityIdStr ?? ''), 'qrId' => (string)($qrIdStr ?? '')]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i> Xem / In QR
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Chưa có mã QR. Tạo mã ở form trên.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>setTimeout(function(){ var a=document.getElementById('flash-alert'); if(a) a.remove(); }, 3000);</script>
@endsection
