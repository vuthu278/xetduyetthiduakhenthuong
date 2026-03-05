@extends('backend.layouts.backend_master')
@section('content')
<div class="container-fluid px-4">
    @if (session('success'))
    <div id="flash-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Hoạt động rèn luyện</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Danh sách hoạt động</li>
                </ol>
            </nav>
        </div>
        @if(get_data_user('admins','level') == 0)
        <a href="{{ route('backend.activity.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm hoạt động
        </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('backend.activity.index') }}" method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Tên hoạt động</label>
                    <input type="text" class="form-control" name="keyword" placeholder="Tên" value="{{ Request::get('keyword') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Đơn vị</label>
                    <select name="department_id" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($departments ?? [] as $d)
                        <option value="{{ mongodb_id_string($d->_id) }}" {{ Request::get('department_id') == mongodb_id_string($d->_id) ? 'selected' : '' }}>{{ $d->name ?? $d->d_name ?? 'Đơn vị #'.mongodb_id_string($d->_id) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" name="time_start" value="{{ Request::get('time_start') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" name="time_stop" value="{{ Request::get('time_stop') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i>Lọc</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 60px">STT</th>
                            <th>Tên hoạt động</th>
                            <th>Đơn vị</th>
                            <th class="text-center">Số SV đăng ký</th>
                            <th>Địa điểm</th>
                            <th>Thời gian</th>
                            @if(get_data_user('admins','level') == 0)
                            <th class="text-center" style="width: 200px">Thao tác</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities ?? [] as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td><h6 class="mb-0">{{ $item->name }}</h6></td>
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
                            @if(get_data_user('admins','level') == 0)
                            <td>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('backend.activity.qr_codes', mongodb_id_string($item->_id)) }}" class="btn btn-sm btn-outline-info" title="QR Code">
                                        <i class="fas fa-qrcode"></i> QR
                                    </a>
                                    <a href="{{ route('backend.activity.update', mongodb_id_string($item->_id)) }}" class="btn btn-sm btn-outline-primary" title="Cập nhật">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('backend.activity.delete', mongodb_id_string($item->_id)) }}" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa hoạt động này?')" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ get_data_user('admins','level') == 0 ? 7 : 6 }}" class="text-center py-4 text-muted">Chưa có hoạt động nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($activities) && $activities->hasPages())
            <div class="d-flex justify-content-center mt-3">{{ $activities->links() }}</div>
            @endif
        </div>
    </div>
</div>
<script>
setTimeout(function(){ var a=document.getElementById('flash-alert'); if(a){ a.classList.remove('show'); a.classList.add('fade'); setTimeout(function(){ a.remove(); }, 300); } }, 3000);
</script>
@endsection
