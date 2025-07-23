@extends('backend.layouts.backend_master')
@section('content')
<div class="container-fluid px-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="flash-alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý tài khoản</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Danh sách tài khoản</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('backend.account.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm tài khoản
        </a>
    </div>
    <form method="GET" action="{{ route('backend.account.index') }}" class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">Tên tài khoản</label>
            <input type="text" class="form-control" name="name" placeholder="Nhập tên..." value="{{ Request::get('name') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại..." value="{{ Request::get('phone') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Nhập email..." value="{{ Request::get('email') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Cấp quản trị</label>
            <select name="level" class="form-select">
                <option value="">Tất cả cấp quản trị</option>
                <option value="0" {{ Request::get('level') == "0" ? "selected" : "" }}>Admin trường</option>
                <option value="1" {{ Request::get('level') != "0" ? "selected" : "" }}>Admin khoa</option>
            </select>
        </div>


        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter me-2"></i>Lọc
            </button>
        </div>
    </form>





    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 60px">STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Đơn vị</th>
                            <th>Ngày tạo</th>
                            <th class="text-center" style="width: 150px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins ?? [] as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary bg-opacity-10 me-2">
                                        <span class="text-primary">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $item->name }}</h6>
                                        <small class="text-muted">{{ $item->level == 0 ? 'Admin trường' : 'Admin khoa' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                @if ($item->level == 0)
                                <span class="badge bg-primary">Admin trường</span>
                                @else
                                <span class="badge bg-primary">{{ $item->department->d_name ?? "..." }}</span>
                                @endif
                            </td>
                            <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('backend.account.update', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Cập nhật">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if ($item->level != 0)
                                    <a href="{{ route('backend.account.delete', $item->id) }}"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa quản trị viên này không?')"
                                        title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Chưa có tài khoản nào</p>
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
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .bg-opacity-10 {
        opacity: 0.1;
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
        background-color: var(--info-color) !important;

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