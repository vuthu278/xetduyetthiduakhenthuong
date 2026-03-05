@extends('backend.layouts.backend_master')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Chi tiết bảng điểm DRL</h1>
        <a href="{{ route('backend.drl_snapshot.index') }}" class="btn btn-outline-secondary">Trở về</a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Thông tin sinh viên</h5>
            <p class="mb-1"><strong>Họ tên:</strong> {{ $snapshot->user->name ?? '-' }}</p>
            <p class="mb-1"><strong>Mã SV:</strong> {{ $snapshot->user->code ?? '-' }}</p>
            <p class="mb-1"><strong>Học kỳ:</strong> {{ $snapshot->semester_key }}</p>
            <p class="mb-1"><strong>Chốt lúc:</strong> {{ $snapshot->finalized_at ? \Carbon\Carbon::parse($snapshot->finalized_at)->format('d/m/Y H:i') : '-' }}</p>
            <p class="mb-0"><strong>Tổng điểm:</strong> <span class="text-primary fs-5">{{ $snapshot->total_points ?? 0 }}</span></p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Chi tiết theo hoạt động</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>STT</th>
                            <th>Hoạt động</th>
                            <th>Trạng thái</th>
                            <th>Điểm cộng</th>
                            <th>Điểm trừ</th>
                            <th>Điểm hoạt động</th>
                            <th>Vào lúc</th>
                            <th>Ra lúc</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($snapshot->details ?? [] as $idx => $d)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $d['activity_name'] ?? '-' }}</td>
                            <td>
                                @if(($d['status'] ?? '') == 'full')
                                <span class="badge bg-success">Đủ</span>
                                @elseif(($d['status'] ?? '') == 'partial')
                                <span class="badge bg-warning text-dark">Thiếu</span>
                                @else
                                <span class="badge bg-secondary">Không tham gia</span>
                                @endif
                            </td>
                            <td class="text-success">+{{ $d['points_added'] ?? 0 }}</td>
                            <td class="text-danger">@if(!empty($d['points_deducted']))-{{ $d['points_deducted'] }}@else 0 @endif</td>
                            <td><strong>{{ $d['points'] ?? 0 }}</strong></td>
                            <td>{{ !empty($d['check_in_at']) ? \Carbon\Carbon::parse($d['check_in_at'])->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ !empty($d['check_out_at']) ? \Carbon\Carbon::parse($d['check_out_at'])->format('d/m/Y H:i') : '-' }}</td>
                            <td class="small text-muted">{{ $d['note'] ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng kết:</strong></td>
                            <td colspan="5"><strong>{{ $snapshot->total_points ?? 0 }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
