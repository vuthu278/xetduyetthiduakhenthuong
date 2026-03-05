@extends('user.layouts.user_master')
@section('content')
<div class="d-flex justify-content-between mt-3">
    <h4 class="">Điểm rèn luyện (DRL)</h4>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}</div>
@endif

<p class="text-muted">Dữ liệu điểm rèn luyện đã được chốt. Chọn học kỳ để xem.</p>

<form method="GET" action="{{ route('user.drl.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label>Học kỳ:</label>
            <select name="semester_key" class="form-control">
                <option value="">Tất cả</option>
                @foreach($semesterKeys ?? [] as $k)
                <option value="{{ $k }}" {{ request('semester_key') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
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
                <td>{{ $item->semester_key }}</td>
                <td><strong>{{ $item->total_points ?? 0 }}</strong></td>
                <td>{{ $item->finalized_at ? \Carbon\Carbon::parse($item->finalized_at)->format('d/m/Y H:i') : '-' }}</td>
                <td>
                    <a href="{{ route('user.drl.show', mongodb_id_string($item->_id)) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">Chưa có dữ liệu điểm rèn luyện đã chốt.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if(isset($snapshots) && $snapshots->hasPages())
<div class="d-flex justify-content-center mt-3">{{ $snapshots->links() }}</div>
@endif
@endsection
