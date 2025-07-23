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
            <h1 class="h3 mb-0">Quản lý danh hiệu</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Danh sách danh hiệu</li>
                </ol>
            </nav>
        </div>
        @if(get_data_user('admins','level') == 0)
        <a href="{{ route('backend.appellation.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm danh hiệu
        </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Đối tượng</label>
                    <select name="type" class="form-select">
                        <option value="">Tất cả đối tượng</option>
                        <option value="1" {{ Request::get('type') == "1" ? "selected" : "" }}>Sinh viên</option>
                        <option value="2" {{ Request::get('type') == "2" ? "selected" : "" }}>Giảng viên</option>

                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tên danh hiệu</label>
                    <input type="text" class="form-control" name="keyword" placeholder="Nhập tên danh hiệu"
                        value="{{ Request::get('keyword') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" name="time_start" value="{{ Request::get('time_start') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" class="form-control" name="time_stop" value="{{ Request::get('time_stop') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Lọc
                    </button>
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
                            <th style="width: 120px">Hình ảnh</th>
                            <th>Tên danh hiệu</th>
                            <th>Đối tượng</th>
                            <th>Đợt thi đua</th>
                            <th>Quyết định</th>
                            <th>Thời gian</th>
                            @if(get_data_user('admins','level') == 0)
                            <th class="text-center" style="width: 150px">Thao tác</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appellations ?? [] as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>
                                <div class="appellation-image">
                                    <a href="{{ pare_url_file($item->avatar) }}" view="">
                                        <img src="{{ pare_url_file($item->avatar) }}" class="img-thumbnail" style="width: 100px" alt="{{ $item->name }}">
                                    </a>
                                    <!-- <img src="{{ pare_url_file($item->avatar) }}" alt="{{ $item->name }}" class="img-thumbnail"> -->
                                </div>
                            </td>
                            <td>
                                <h6 class="mb-0">{{ $item->name }}</h6>
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->type == 1 ? 'primary' : 'info' }}">
                                    {{ $item->type == 1 ? "Sinh viên" : "Giảng viên" }}
                                </span>
                            </td>
                            <td>{{ $item->semesters_name }}</td>
                            <td>
                                @if($item->rule)
                                <a href="{{ pare_url_file($item->rule) }}" download class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>Tải xuống
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
                            @if(get_data_user('admins','level') == 0)
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('backend.appellation.update', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Cập nhật">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('backend.appellation.delete', $item->id) }}"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh hiệu này không?')"
                                        title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ get_data_user('admins','level') == 0 ? '8' : '7' }}" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-award fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Chưa có danh hiệu nào</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .appellation-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
    }

    .appellation-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-label {
        font-weight: 500;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .form-select,
    .form-control {
        border-color: #e0e0e0;
        padding: 0.5rem 1rem;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.25);
    }

    .table> :not(caption)>*>* {
        padding: 1rem;
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-danger {
        border-color: var(--danger-color);
        color: var(--danger-color);
    }

    .btn-outline-danger:hover {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .empty-state {
        padding: 2rem;
        text-align: center;
    }

    .badge {
        padding: 0.5em 1em;
        font-weight: 500;
    }

    .bg-info {
        /* background-color: var(--info-color) !important; */
        background-color: rgb(247, 210, 5) !important;
    }
</style>
<script>
    setTimeout(function() {
        const alert = document.getElementById('flash-alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 300);
        }
    }, 3000);
</script>

@endsection