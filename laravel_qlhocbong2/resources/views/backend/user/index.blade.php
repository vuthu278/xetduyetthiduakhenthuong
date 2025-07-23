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

    .filter-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(26, 115, 232, 0.07);
        padding: 1.5rem 1rem;
        margin-bottom: 1.5rem;
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
        max-width: 160px;
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

        .filter-card,
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
<div class="filter-card mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Ứng viên</h4>
        <a href="{{ route('backend.user.create') }}" title="Thêm mới" class="btn btn-success d-flex align-items-center">
            <i class="fa fa-plus me-2"></i> Thêm mới
        </a>
    </div>
    <form action="" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label mb-1">Đối tượng</label>
            <select name="type" class="form-control">
                <option value="">Lọc đối tượng</option>
                <option value="1" {{ (Request::get('type') ?? 0) == 1 ? "selected" : "" }}>Sinh viên</option>
                <option value="2" {{ (Request::get('type') ?? 0) == 2 ? "selected" : "" }}>Giảng viên</option>
            </select>
        </div>
        @if (get_data_user('admins','level') == 0)
        <div class="col-md-3">
            <label class="form-label mb-1">Đơn vị</label>
            <select name="department_id" class="form-control">
                <option value="">Lọc đơn vị</option>
                @foreach($departments ?? [] as $item)
                <option value="{{ $item->id }}" {{ ($user->department_id ?? 0) == $item->id ? "selected" : "" }}>{{ $item->d_name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="col-md-2">
            <label class="form-label mb-1">Tên ứng viên</label>
            <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}" placeholder="Name">
        </div>
        <div class="col-md-2">
            <label class="form-label mb-1">Mã ứng viên</label>
            <input type="text" class="form-control" name="code" value="{{ Request::get('code') }}" placeholder="Code">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-2"></i>Lọc</button>
        </div>
    </form>
</div>
<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã ứng viên</th>
                <th scope="col" class="truncate">Họ tên</th>
                <th scope="col" class="truncate">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col" class="truncate">Đơn vị</th>
                <th scope="col">Đối tượng</th>
                <th scope="col" style="min-width:120px;" class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @if($users->isEmpty())
            <tr>
                <td colspan="8" class="text-center text-danger fw-bold">
                    Không tìm thấy ứng viên nào phù hợp.
                </td>
            </tr>
            @else
            @foreach($users ?? [] as $key => $item)
            <tr>
                <th scope="row">{{ ($key + 1)  }}</th>
                <td>{{ $item->code }}</td>
                <td class="truncate" title="{{ $item->name }}">{{ $item->name }}</td>
                <td class="truncate" title="{{ $item->email }}">{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td class="truncate" title="{{ $item->department->d_name ?? '...' }}">{{ $item->department->d_name ?? "..." }}</td>
                <td>{{ $item->type == 1 ? "Sinh viên" : ($item->type == 2 ? "Giảng viên" : "Nhân viên")}}</td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('backend.user.update', $item->id) }}" class="btn btn-primary" title="Cập nhật">
                            <i class="fa fa-pencil-square-o"></i>
                            <span>Cập nhật</span>
                        </a>
                        <a href="{{ route('backend.user.delete', $item->id) }}"
                            class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?')"
                            title="Xóa">
                            <i class="fa fa-trash-o"></i>
                            <span>Xóa</span>
                        </a>

                    </div>
                </td>
            </tr>
            @endforeach
            @endif
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