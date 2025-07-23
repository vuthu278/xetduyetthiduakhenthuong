@extends('user.layouts.user_master')
@section('content')
<div class="d-flex justify-content-between mt-3">
    <h4 class="">Danh hiệu</h4>
</div>
<style>
    html,
    body {
        overflow: auto !important;
        /* Cho phép cuộn */
        height: auto !important;
    }

    td {
        word-wrap: break-word;
        /* Giúp chữ tự động xuống dòng */
        white-space: normal;
        /* Cho phép văn bản ngắt dòng tự nhiên */
    }

    td:nth-child(6) {
        max-width: 300px;
        /* Giới hạn độ rộng của cột "Mô tả" */
        overflow-wrap: break-word;
        /* Nếu nội dung dài, sẽ xuống dòng */
    }
</style>
<form method="GET" action="{{ route('user.appellation.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label>Tên danh hiệu:</label>
            <input type="text" name="name" class="form-control" placeholder="Nhập tên danh hiệu..." value="{{ request('name') }}">
        </div>
        <div class="col-md-3">
            <label>Ngày bắt đầu:</label>
            <input type="date" name="time_start" class="form-control" value="{{ request('time_start') }}">
        </div>
        <div class="col-md-3">
            <label>Ngày kết thúc:</label>
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
                <th scope="col">STT</th>
                <th scope="col">Avatar</th>
                <th scope="col">Tên</th>
                <th scope="col">Đợt thi đua</th>
                <th scope="col">Đối tượng</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Quyết định</th>
                <th scope="col">Ngày bắt đầu</th>
                <th scope="col">Ngày kết thúc</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appellations ?? [] as $key => $item)
            <tr>
                <th scope="row">{{ ($key + 1)  }}</th>
                <td>
                    <a href="{{ pare_url_file($item->avatar) }}" target="_blank">
                        <img src="{{ pare_url_file($item->avatar) }}" style="width: 100px" alt="">
                    </a>
                </td>

                <td>{{ $item->name }}</td>
                <td>{{ $item->semesters_name }}</td>
                <td>{{ $item->type == 1 ? "Sinh viên" : ($item->type == 2 ? "Giảng viên" : "Nhân viên") }}</td>
                <td class="description-cell">{{ $item->note }}</td>
                <td>
                    @if ($item->rule)
                    <a href="{{ pare_url_file($item->rule) }}" download="">Tải xuống</a>
                    @endif
                </td>
                <td>{{ $item->time_start }}</td>
                <td>{{ $item->time_stop }}</td>
                <td>
                    @if (strtotime($item->time_stop) >= strtotime(date('Y-m-d')))
                    <a href="{{ route('user.appellation_register.create') }}?appellation={{ $item->id }}" class="btn btn-sm btn-primary">Đăng ký</a>
                    @else
                    <span class="text-danger fw-bold">Hết hạn</span>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop