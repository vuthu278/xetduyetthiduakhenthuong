@extends('backend.layouts.backend_master')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Điểm danh hoạt động</h1>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('backend.activity_attendance.index') }}" method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Hoạt động</label>
                    <select name="activity_id" class="form-select">
                        <option value="">Tất cả</option>
                        @php $selAid = Request::get('activity_id'); $selAid = is_array($selAid) ? ($selAid[0] ?? '') : ($selAid ?? ''); @endphp
                        @foreach($activities ?? [] as $a)
                        <option value="{{ mongodb_id_string($a->_id) }}" {{ $selAid == mongodb_id_string($a->_id) ? 'selected' : '' }}>{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Loại</label>
                    <select name="type" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="1" {{ Request::get('type') == '1' ? 'selected' : '' }}>QR Vào</option>
                        <option value="2" {{ Request::get('type') == '2' ? 'selected' : '' }}>QR Ra</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" name="date_from" value="{{ Request::get('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" name="date_to" value="{{ Request::get('date_to') }}">
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
                            <th>Hoạt động</th>
                            <th class="text-center">Quét Vào</th>
                            <th class="text-center">Quét Ra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances ?? [] as $key => $row)
                        <tr>
                            <td>{{ ($attendances->currentPage()-1) * $attendances->perPage() + $key + 1 }}</td>
                            <td>{{ $row['user']->name ?? '-' }} ({{ $row['user']->code ?? '-' }})</td>
                            <td>{{ $row['activity']->name ?? '-' }}</td>
                            <td class="text-center">
                                @if($row['check_in'] ?? null)
                                <span class="badge bg-success">{{ \Carbon\Carbon::parse($row['check_in']->scanned_at)->format('d/m/Y H:i') }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($row['check_out'] ?? null)
                                <span class="badge bg-info">{{ \Carbon\Carbon::parse($row['check_out']->scanned_at)->format('d/m/Y H:i') }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">Chưa có bản ghi điểm danh.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($attendances) && $attendances->hasPages())
            <div class="d-flex justify-content-center mt-3">{{ $attendances->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
