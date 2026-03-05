@extends('user.layouts.user_master')
@section('content')
<div class="d-flex justify-content-between align-items-center mt-3">
    <h4 class="">Chi tiết điểm rèn luyện - {{ $snapshot->semester_key }}</h4>
    <a href="{{ route('user.drl.index') }}" class="btn btn-outline-secondary">Quay lại</a>
</div>

<div class="card mt-3">
    <div class="card-body">
        <p class="mb-2"><strong>Tổng điểm:</strong> {{ $snapshot->total_points ?? 0 }}</p>
        <p class="mb-3 text-muted small">Chốt lúc: {{ $snapshot->finalized_at ? \Carbon\Carbon::parse($snapshot->finalized_at)->format('d/m/Y H:i') : '-' }}</p>

        <h6>Chi tiết theo hoạt động</h6>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Hoạt động</th>
                        <th>Trạng thái</th>
                        <th>Điểm cộng</th>
                        <th>Điểm trừ</th>
                        <th>Điểm</th>
                        <th>Vào lúc</th>
                        <th>Ra lúc</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($snapshot->details ?? [] as $d)
                    <tr>
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
                        <td class="text-success">+{{ $d['points_added'] ?? (($d['points'] ?? 0) > 0 ? $d['points'] : 0) }}</td>
                        <td class="text-danger">@if(!empty($d['points_deducted']))-{{ $d['points_deducted'] }}@else 0 @endif</td>
                        <td><strong>{{ $d['points'] ?? 0 }}</strong></td>
                        <td>{{ !empty($d['check_in_at']) ? \Carbon\Carbon::parse($d['check_in_at'])->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ !empty($d['check_out_at']) ? \Carbon\Carbon::parse($d['check_out_at'])->format('d/m/Y H:i') : '-' }}</td>
                        <td class="small text-muted">{{ $d['note'] ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
