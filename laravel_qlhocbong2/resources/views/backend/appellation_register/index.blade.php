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
            <h1 class="h3 mb-0">Quản lý đăng ký danh hiệu</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li> -->
                    <li class="breadcrumb-item active">Danh sách đăng ký</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="0" {{ (Request::get('status')) === '0' ? "selected" : "" }}>Chờ xét duyệt</option>
                        <option value="1" {{ (Request::get('status')) == 1 ? "selected" : "" }}>Đã xem</option>
                        <option value="2" {{ (Request::get('status')) == 2 ? "selected" : "" }}>Được đề nghị xét duyệt</option>
                        <option value="-1" {{ (Request::get('status')) == -1 ? "selected" : "" }}>Không được đề nghị xét duyệt</option>
                        <option value="3" {{ (Request::get('status')) == 3 ? "selected" : "" }}>Đạt danh hiệu</option>
                        <option value="4" {{ (Request::get('status')) == 4 ? "selected" : "" }}>Không đạt danh hiệu</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đối tượng</label>
                    <select name="type" class="form-select">
                        <option value="">Tất cả đối tượng</option>
                        <option value="1" {{ (Request::get('type') ?? 0) == 1 ? "selected" : "" }}>Sinh viên</option>
                        <option value="2" {{ (Request::get('type') ?? 0) == 2 ? "selected" : "" }}>Giảng viên</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tên ứng viên</label>
                    <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}" placeholder="Nhập tên...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Mã ứng viên</label>
                    <input type="text" class="form-control" name="code" value="{{ Request::get('code') }}" placeholder="Nhập mã...">
                </div>
                <div class="col-md-6 d-flex align-items-end">
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
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Danh hiệu</th>
                            <th style="width: 150px">Chứng nhận</th>
                            <th>Trạng thái</th>
                            <th>Ngày xét duyệt</th>
                            <th class="text-center" style="width: 150px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appellationsRegister ?? [] as $key => $item)
                        <tr>
                             <td class="text-center">{{ ($appellationsRegister->currentPage() - 1) * $appellationsRegister->perPage() + $key + 1 }}</td>
                            <td>
                                <span class="fw-medium">{{ $item->code }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- TẠO TÊN VIẾT TẮT -->
                                    <!-- <div class="avatar-circle bg-primary bg-opacity-10 me-2">
                                        <span class="text-primary">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                    </div> -->
                                    <div>
                                        <h6 class="name-item">{{ $item->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->appellation->name ?? "..." }}</span>
                            </td>
                            <td>
                                @if($item->certification)
                                <div class="certificate-preview">
                                    <a href="{{ asset('certificate/'.$item->certification) }}">
                                        <img src="{{ asset('certificate/'.$item->certification) }}" alt="Chứng nhận">
                                    </a>
                                </div>
                                @else
                                <span class="text-muted">Không có</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->getStatus($item->status)['class'] ?? 'secondary' }}">
                                    {{ $item->getStatus($item->status)['name'] ?? "..." }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $item->time_process ? date('d/m/Y', strtotime($item->time_process)) : "..." }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('backend.appellation_register.update', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Cập nhật">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('backend.appellation_register.delete', $item->id) }}"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa xét duyệt danh hiệu này không?')"
                                        title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Chưa có đăng ký nào</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                <div class="record-count">
                    <span class="fw-medium">Tổng số bản ghi:</span>
                    <strong>{{ $appellationsRegister->total() ?? 0 }}</strong>
                </div>

                <nav class="pagination-nav">
                    <ul class="pagination">
                        @if ($appellationsRegister->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $appellationsRegister->previousPageUrl() }}">Previous</a>
                        </li>
                        @endif

                        @if ($appellationsRegister->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $appellationsRegister->nextPageUrl() }}">Next</a>
                        </li>
                        @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                        @endif
                    </ul>
                </nav>
            </div>


        </div>
    </div>
</div>

<style>
    .name-item {
        width: 150px;
    }

    /* Bảng */
    .table> :not(caption)>*>* {
        padding: 1rem;
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    /* Form Elements */
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

    /* Nút */
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

    /* Empty State */
    .empty-state {
        padding: 2rem;
        text-align: center;
    }

    /* Badge */
    .badge {
        padding: 0.5em 1em;
        font-weight: 500;
    }

    /* Avatar */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    /* Chứng nhận */
    .certificate-preview {
        width: 110%;
        height: 110%;
        overflow: hidden;
    }

    .certificate-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .record-count {
        font-size: 14px;
        color: #6c757d;
    }

    /* Phân trang */
    .pagination-nav .pagination {
        display: flex;
        gap: 10px;
    }

    .pagination .page-item .page-link {
        color: #1565c0;
        background: #ffffff;
        border-radius: 6px;
        padding: 8px 12px;
        transition: 0.3s;
        border: 1px solid #dee2e6;
        text-decoration: none;
        font-weight: 500;
    }

    .pagination .page-item .page-link:hover {
        background: #004ba0;
        color: #ffffff;
        transform: scale(1.05);
    }

    .pagination .page-item.disabled .page-link {
        color: #aaa;
        background: #e0e0e0;
        cursor: not-allowed;
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