@extends('backend.layouts.backend_master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        @if($is_department_admin && $current_department)
        <li class="breadcrumb-item active">{{ $current_department->name }}</li>
        @endif
    </ol>

    <div class="row">
        <!-- Thống kê tổng quan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-primary bg-gradient">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">
                                @if($is_department_admin && $current_department)
                                Tổng số ứng viên {{ $current_department->name }}
                                @else
                                Tổng số ứng viên
                                @endif
                            </h6>
                            <h4 class="mb-0">{{ $total_user ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('backend.user.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-success bg-gradient">
                                <i class="fas fa-award text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Danh hiệu</h6>
                            <h4 class="mb-0">{{ $total_appellation ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('backend.appellation.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-info bg-gradient">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">
                                @if($is_department_admin && $current_department)
                                Đăng ký danh hiệu {{ $current_department->name }}
                                @else
                                Đăng ký danh hiệu
                                @endif
                            </h6>
                            <h4 class="mb-0">{{ $total_register ?? 0 }}</h4>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Đạt danh hiệu:</small>
                            <a href="{{ route('backend.appellation_register.index', ['status' => 3]) }}" class="text-decoration-none">
                                <span class="badge" style="background-color: #28a745 !important;">{{ $register_status['Đạt danh hiệu'] ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Được đề nghị xét duyệt:</small>
                            <a href="{{ route('backend.appellation_register.index', ['status' => 2]) }}" class="text-decoration-none">
                                <span class="badge bg-warning">{{ $register_status['Được đề nghị xét duyệt'] ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Đã xem:</small>
                            <a href="{{ route('backend.appellation_register.index', ['status' => 1]) }}" class="text-decoration-none">
                                <span class="badge bg-info">{{ $register_status['Đã xem'] ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Không được đề nghị xét duyệt:</small>
                            <a href="{{ route('backend.appellation_register.index', ['status' => -1]) }}" class="text-decoration-none">
                                <span class="badge bg-danger">{{ $register_status['Không được đề nghị xét duyệt'] ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Không đạt danh hiệu:</small>
                            <a href="{{ route('backend.appellation_register.index', ['status' => 4]) }}" class="text-decoration-none">
                                <span class="badge bg-primary">{{ $register_status['Không đạt danh hiệu'] ?? 0 }}</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Chờ xét duyệt:</small>
                            <a href="{{ route('backend.appellation_register.index', ['status' => 0]) }}" class="text-decoration-none">
                                <span class="badge bg-secondary">{{ $register_status['Chờ xét duyệt'] ?? 0 }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('backend.appellation_register.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        @if(isset($level) && $level == 0)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-warning bg-gradient">
                                <i class="fas fa-building text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Khoa/Phòng ban</h6>
                            <h4 class="mb-0">{{ $total_department ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('backend.department.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif
        @if(isset($level) && $level == 0)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-primary bg-gradient">
                                <i class="fas fa-user-shield text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Quản trị viên</h6>
                            <h4 class="mb-0">{{ $total_admins ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('backend.account.index') }}" class="text-decoration-none">
                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif





    </div>

    <!-- Danh sách đăng ký mới nhất -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Danh sách ứng viên mới nhất</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã ứng viên</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Đơn vị</th>
                        <th>Đối tượng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($highlight_users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->code ?? 'N/A' }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td class="truncate" title="{{ optional($user->department)->d_name ?? '...' }}">{{ optional($user->department)->d_name ?? "..." }}</td>
                        <td>
                            {{ $user->type == 1 ? 'Sinh viên' : ($user->type == 2 ? 'Giảng viên' : 'Khác') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 text-center">
            <a href="{{ route('backend.user.index') }}" class="btn btn-outline-primary">
                Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <!-- Danh sách danh hiệu đã đăng ký -->
    <!-- Danh sách danh hiệu mới nhất -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Danh sách danh hiệu mới nhất</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" style="width: 60px">STT</th>
                        <th style="width: 120px">Hình ảnh</th>
                        <th>Tên danh hiệu</th>
                        <th>Đối tượng</th>
                        <th>Đợt thi đua</th>
                        <th>Quyết định</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest_appellations ?? [] as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="appellation-image">
                                <a href="{{ pare_url_file($item->avatar) }}" target="_blank">
                                    <img src="{{ pare_url_file($item->avatar) }}" class="img-thumbnail" style="width: 100px" alt="{{ $item->name }}">
                                </a>
                            </div>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <span class="badge bg-{{ $item->type == 1 ? 'primary' : 'info' }}">
                                {{ $item->type == 1 ? 'Sinh viên' : 'Giảng viên' }}
                            </span>
                        </td>
                        <td>{{ $item->semesters_name }}</td>
                        <td>
                            @if($item->rule)
                            <a href="{{ pare_url_file($item->rule) }}" download class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download me-1"></i> Tải xuống
                            </a>
                            @else
                            <span class="text-muted">Không có</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <small class="text-muted">Bắt đầu: {{ date('d/m/Y', strtotime($item->time_start)) }}</small>
                                <small class="text-muted">Kết thúc: {{ date('d/m/Y', strtotime($item->time_stop)) }}</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 text-center">
            <a href="{{ route('backend.appellation.index') }}" class="btn btn-outline-primary">
                Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <!-- Danh sách xét duyệt danh hiệu -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Xét duyệt danh hiệu mới nhất</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" style="width: 60px">STT</th>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Danh hiệu</th>
                        <th style="width: 150px">Chứng nhận</th>
                        <th>Trạng thái</th>
                        <th>Ngày xét duyệt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest_reviews ?? [] as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->appellation->name ?? '...' }}</td>
                        <td>
                            @if($item->certification)
                            <a href="{{ asset('certificate/'.$item->certification) }}">
                                <img src="{{ asset('certificate/'.$item->certification) }}" class="img-thumbnail" style="width: 100px" alt="Chứng nhận">
                            </a>
                            @else
                            <span class="text-muted">Không có</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $item->getStatus($item->status)['class'] ?? 'secondary' }}">
                                {{ $item->getStatus($item->status)['name'] ?? "..." }}
                            </span>
                        </td>
                        <td>{{ $item->time_process ? date('d/m/Y', strtotime($item->time_process)) : '...' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 text-center">
            <a href="{{ route('backend.appellation_register.index') }}" class="btn btn-outline-primary">
                Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @if(isset($level) && $level == 0)
    <!-- Danh sách khoa mới nhất -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Danh sách khoa mới nhất</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="text-left" style="width: 100px; padding-left: 30px;">STT</th>
                        <th style="width: 120px; padding-left: 20px;">Mã khoa</th>
                        <th style="width: 250px; padding-left: 20px;">Tên khoa</th>
                        <th style="width: 150px; padding-left: 20px;">Ngày tạo</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($latest_departments ?? [] as $index => $item)
                    <tr>
                        <td class="text-right" style="padding-left: 35px;">{{ $index + 1 }}</td>
                        <td class="text-right" style="padding-left: 20px;">{{ $item->d_code }}</td>
                        <td class="text-right truncate" style="padding-left: 20px;" title="{{ $item->d_name }}">{{ $item->d_name }}</td>
                        <td class="text-right" style="padding-left: 20px;">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 text-center">
            <a href="{{ route('backend.department.index') }}" class="btn btn-outline-primary">
                Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endif
    @if(isset($level) && $level == 0)
    <!-- Danh sách quản trị viên mới nhất -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Danh sách quản trị viên mới nhất</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" style="width: 60px">STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Đơn vị</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($latest_admins ?? [] as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            @if ($item->level == 0)
                            <span class="badge bg-primary">Admin trường</span>
                            @else
                            <span class="badge bg-primary">{{ $item->department->d_name ?? "Không xác định" }}</span>
                            @endif
                        </td>

                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 text-center">
            <a href="{{ route('backend.account.index') }}" class="btn btn-outline-primary">
                Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endif

</div>

<style>
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .bg-gradient {
        background: var(--gradient);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-footer a {
        color: var(--primary-color);
        transition: all 0.3s ease;
    }

    .card-footer a:hover {
        color: var(--secondary-color);
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        color: var(--dark-color);
    }

    .badge {
        padding: 0.5em 1em;
        font-weight: 500;
    }

    .bg-success {
        background: var(--success-color) !important;
    }

    .bg-warning {
        background: #ffc107 !important;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            // Đăng ký danh hiệu theo tháng
            const registrationData = @json($register_by_month ?? []);
            const registrationCanvas = document.getElementById('registrationChart');
            if (registrationCanvas) {
                const registrationCtx = registrationCanvas.getContext('2d');
                if (!registrationData.length || registrationData.every(v => v === 0)) {
                    registrationCtx.clearRect(0, 0, registrationCanvas.width, registrationCanvas.height);
                    registrationCtx.font = '18px Poppins, Arial, sans-serif';
                    registrationCtx.textAlign = 'center';
                    registrationCtx.fillStyle = '#888';
                    registrationCtx.fillText('Không có dữ liệu', registrationCanvas.width / 2, registrationCanvas.height / 2);
                } else {
                    new Chart(registrationCtx, {
                        type: 'line',
                        data: {
                            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                            datasets: [{
                                label: 'Số lượng đăng ký',
                                data: registrationData,
                                borderColor: '#1a73e8',
                                backgroundColor: 'rgba(26, 115, 232, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            } else {
                console.error('Không tìm thấy canvas #registrationChart');
            }

            // Danh hiệu phổ biến
            const popularLabels = @json(collect($popular_appellations ?? []) -> pluck('name') -> toArray());
            const popularData = @json(collect($popular_appellations ?? []) -> pluck('total') -> toArray());


            const appellationCanvas = document.getElementById('appellationChart');
            if (appellationCanvas) {
                const appellationCtx = appellationCanvas.getContext('2d');
                if (!popularData.length || popularData.every(v => v === 0)) {
                    appellationCtx.clearRect(0, 0, appellationCanvas.width, appellationCanvas.height);
                    appellationCtx.font = '18px Poppins, Arial, sans-serif';
                    appellationCtx.textAlign = 'center';
                    appellationCtx.fillStyle = '#888';
                    appellationCtx.fillText('Không có dữ liệu', appellationCanvas.width / 2, appellationCanvas.height / 2);
                } else {
                    new Chart(appellationCtx, {
                        type: 'doughnut',
                        data: {
                            labels: popularLabels,
                            datasets: [{
                                data: popularData,
                                backgroundColor: [
                                    '#1a73e8', '#0d47a1', '#2196f3', '#03a9f4', '#ffc107'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            } else {
                console.error('Không tìm thấy canvas #appellationChart');
            }
        } catch (e) {
            console.error('Lỗi khi vẽ biểu đồ:', e);
        }
    });
</script>
@endpush
@endsection