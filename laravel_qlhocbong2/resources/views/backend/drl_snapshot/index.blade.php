@extends('backend.layouts.backend_master')
@section('content')
<div class="container-fluid px-4">
    @if (session('success'))
    <div id="flash-alert" class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Chốt điểm DRL</h1>
        <a href="{{ route('backend.drl_snapshot.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Chốt điểm mới</a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('backend.drl_snapshot.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Học kỳ</label>
                    <select name="semester_key" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($semesterKeys ?? [] as $k)
                        <option value="{{ $k }}" {{ Request::get('semester_key') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tên / Mã SV</label>
                    <input type="text" class="form-control" name="keyword" placeholder="Tìm theo tên hoặc mã" value="{{ Request::get('keyword') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>STT</th>
                            <th>Sinh viên</th>
                            <th>Mã SV</th>
                            <th>Học kỳ</th>
                            <th>Tổng điểm</th>
                            <th>Chốt lúc</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($snapshots ?? [] as $key => $item)
                        <tr>
                            <td>{{ ($snapshots->currentPage()-1) * $snapshots->perPage() + $key + 1 }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->user->code ?? '-' }}</td>
                            <td>{{ $item->semester_key }}</td>
                            <td><strong>{{ $item->total_points ?? 0 }}</strong></td>
                            <td>{{ $item->finalized_at ? \Carbon\Carbon::parse($item->finalized_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('backend.drl_snapshot.show', $item->getRouteKey()) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết bảng điểm">Xem chi tiết</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">Chưa có bản ghi chốt điểm. Thực hiện "Chốt điểm mới" để tổng hợp.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($snapshots) && $snapshots->hasPages())
            <div class="d-flex justify-content-center mt-3">{{ $snapshots->links() }}</div>
            @endif
        </div>
    </div>
</div>
<script>setTimeout(function(){ var a=document.getElementById('flash-alert'); if(a) a.remove(); }, 3000);</script>
@endsection
