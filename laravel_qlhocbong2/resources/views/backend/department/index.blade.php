@extends('backend.layouts.backend_master')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="flash-alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<style>
    body,
    .table,
    .form-control,
    .btn {
        font-family: 'Poppins', Arial, Helvetica, sans-serif;
    }

    .header-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(26, 115, 232, 0.07);
        padding: 1.2rem 1rem 1rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-responsive {
        border-radius: 1rem;
        background: #fff;
        box-shadow: 0 2px 12px rgba(26, 115, 232, 0.07);
        padding: 1.5rem 1rem;
    }

    .table th,
    .table td {
        vertical-align: middle;
        white-space: nowrap;
        font-size: 1rem;
    }

    .table td.truncate,
    .table th.truncate {
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .action-btns {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .action-btns .btn {
        min-width: 48px;
        min-height: 40px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        transition: background 0.2s, color 0.2s;
    }

    .action-btns .btn-primary {
        background: var(--primary-color);
        border: none;
        color: #fff;
    }

    .action-btns .btn-danger {
        background: #e53935;
        border: none;
        color: #fff;
    }

    .action-btns .btn i {
        margin-right: 0.3rem;
        font-size: 1.2rem;
    }

    .action-btns .btn span {
        display: inline;
    }

    @media (max-width: 991.98px) {

        .header-card,
        .table-responsive {
            padding: 1rem 0.2rem;
        }

        .table th,
        .table td {
            font-size: 0.95rem;
        }

        .action-btns .btn {
            min-width: 38px;
            min-height: 32px;
            font-size: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .action-btns .btn span {
            display: none;
        }
    }
</style>
<div class="header-card mb-4">
    <h4 class="mb-0">Khoa</h4>
    <a href="{{ route('backend.department.create') }}" title="Thêm mới" class="btn btn-success d-flex align-items-center">
        <i class="fa fa-plus me-2"></i> <span>Thêm mới</span>
    </a>
</div>
<div class="filter-card mb-4 p-3 bg-white rounded shadow-sm">
    <form method="GET" action="{{ route('backend.department.index') }}" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Mã khoa</label>
            <input type="text" class="form-control" name="d_code" placeholder="Nhập mã khoa..." value="{{ Request::get('d_code') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tên khoa</label>
            <input type="text" class="form-control" name="d_name" placeholder="Nhập tên khoa..." value="{{ Request::get('d_name') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter me-2"></i>Lọc
            </button>
        </div>
    </form>
</div>



<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã khoa</th>
                <th scope="col" class="truncate">Tên khoa</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col" style="min-width:120px;" class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments ?? [] as $key => $item)
            <tr>
                <th scope="row">{{ ($key + 1)  }}</th>
                <td>{{ $item->d_code }}</td>
                <td class="truncate" title="{{ $item->d_name }}">{{ $item->d_name }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                <td class="text-center">
                    <div class="action-btns">
                        <a href="{{ route('backend.department.update', $item->id) }}" class="btn btn-primary" title="Cập nhật">
                            <i class="fa fa-pencil-square-o"></i>
                            <span>Cập nhật</span>
                        </a>
                        <a href="{{ route('backend.department.delete', $item->id) }}"
                            class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa đơn vị khoa này không?')"
                            title="Xóa">
                            <i class="fa fa-trash-o"></i>
                            <span>Xóa</span>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
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