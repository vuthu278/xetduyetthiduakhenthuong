@extends('user.layouts.user_master')
@section('content')
<div class="d-flex justify-content-between mt-3">
    <h4 class="">Hoạt động rèn luyện</h4>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}</div>
@endif

<form method="GET" action="{{ route('user.activity.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label>Tên hoạt động:</label>
            <input type="text" name="keyword" class="form-control" placeholder="Nhập tên..." value="{{ request('keyword') }}">
        </div>
        <div class="col-md-3">
            <label>Từ ngày:</label>
            <input type="date" name="time_start" class="form-control" value="{{ request('time_start') }}">
        </div>
        <div class="col-md-3">
            <label>Đến ngày:</label>
            <input type="date" name="time_stop" class="form-control" value="{{ request('time_stop') }}">
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
                <th>Tên hoạt động</th>
                <th>Đơn vị tổ chức</th>
                <th class="text-center">Số SV đăng ký</th>
                <th>Địa điểm</th>
                <th>Thời gian</th>
                <th class="text-center">Đăng ký</th>
                <th>Hướng dẫn</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities ?? [] as $key => $item)
            <tr>
                <td>{{ ($activities->currentPage()-1) * $activities->perPage() + $key + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    @php
                        $deptKey = mongodb_id_string($item->department_id ?? '');
                        $deptName = ($departmentNames ?? [])[$deptKey] ?? ($departmentNames ?? [])[(string)($item->department_id ?? '')] ?? optional($item->department)->d_name ?? optional($item->department)->name ?? '-';
                    @endphp
                    {{ $deptName }}
                </td>
                <td class="text-center">
                    @php
                        $cnt = $registrationCounts[mongodb_id_string($item->_id ?? $item->id ?? '')] ?? 0;
                        $max = (int) ($item->max_registrations ?? 0);
                    @endphp
                    <span class="badge bg-info">{{ $max > 0 ? $cnt . '/' . $max : $cnt }}</span>
                </td>
                <td>{{ $item->location ?? '-' }}</td>
                <td>
                    <small>Bắt đầu: {{ $item->time_start ? date('d/m/Y H:i', strtotime($item->time_start)) : '-' }}</small><br>
                    <small>Kết thúc: {{ $item->time_stop ? date('d/m/Y H:i', strtotime($item->time_stop)) : '-' }}</small>
                </td>
                <td class="text-center">
                    @php
                        $reg = $registrations[mongodb_id_string($item->_id ?? $item->id ?? '')] ?? null;
                        $now = now();
                        $canRegister = $item->time_start ? $now->lt(\Carbon\Carbon::parse($item->time_start)) : true;
                        $canCancel = $item->time_start ? $now->lt(\Carbon\Carbon::parse($item->time_start)) : true;
                        $cnt = $registrationCounts[mongodb_id_string($item->_id ?? $item->id ?? '')] ?? 0;
                        $max = (int) ($item->max_registrations ?? 0);
                        $isFull = $max > 0 && $cnt >= $max;
                    @endphp
                    @if(!$reg || $reg->status !== \App\Models\ActivityRegistration::STATUS_REGISTERED)
                        @if($canRegister && !$isFull)
                        <form method="POST" action="{{ route('user.activity.register', mongodb_id_string($item->_id)) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Đăng ký</button>
                        </form>
                        @elseif($isFull)
                        <span class="badge bg-warning text-dark small">Đã đủ số lượng</span>
                        @else
                        <span class="badge bg-secondary small">Hết hạn đăng ký</span>
                        @endif
                    @else
                        @if($canCancel)
                        <form method="POST" action="{{ route('user.activity.cancel', mongodb_id_string($item->_id)) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hủy đăng ký</button>
                        </form>
                        @else
                        <span class="badge bg-success small">Đã đăng ký</span>
                        @endif
                    @endif
                </td>
                <td>
                    <p class="mb-0 small text-muted">
                        - Bước 1: Đăng ký tham gia trên hệ thống trước thời hạn.<br>
                        - Bước 2: Đến đúng địa điểm, quét <strong>QR Vào</strong> khi tới và <strong>QR Ra</strong> khi về để được ghi nhận điểm danh.
                    </p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if(isset($activities) && $activities->hasPages())
<div class="d-flex justify-content-center mt-3">{{ $activities->links() }}</div>
@endif
@endsection
