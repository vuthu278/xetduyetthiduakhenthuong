@extends('user.layouts.user_master')
@section('content')
@if (session('success'))
<div id="flash-alert" class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
</div>
@endif
<div class="d-flex justify-content-between mt-3">
    <h4 class="">Danh sách</h4>
    {{-- <a href="{{ route('user.appellation_register.create') }}" title="Thêm mới" class="btn btn-success">Thêm mới <i class="fa fa-plus"></i></a> --}}
</div>
<style>
    html,
    body {
        overflow: auto !important;
        /* Cho phép cuộn */
        height: auto !important;
    }
</style>
<div>
    <form action="" class="form-horizontal row">
        <div class="mb-3 col-sm-4">
            <label for="register_date" class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="">Tất cả trạng thái</option>
                <option value="0" {{ (Request::get('status') === "0") ? "selected" : "" }}>Chờ xét duyệt</option>
                <option value="1" {{ (Request::get('status') == 1 ? "selected" : "") }}>Đã xem</option>
                <option value="2" {{ (Request::get('status') == 2 ? "selected" : "") }}>Được đề nghị xét duyệt</option>
                <option value="-1" {{ (Request::get('status') == -1 ? "selected" : "") }}>Không được đề nghị xét duyệt</option>
                <option value="3" {{ (Request::get('status') == 3 ? "selected" : "") }}>Đạt danh hiệu</option>
                <option value="4" {{ (Request::get('status') == 4 ? "selected" : "") }}>Không đạt danh hiệu</option>


            </select>

        </div>
        <div class="mb-3 col-sm-4">
            <label for="register_date" class="form-label">Tên danh hiệu</label>
            <input type="text" class="form-control" name="name" placeholder="Nhập tên danh hiệu..." value="{{ Request::get('name') }}">
        </div>
        <div class="mb-3 col-sm-4">
            <label for="register_date" class="form-label">Ngày đăng ký</label>
            <input type="date" class="form-control" name="register_date" value="{{ Request::get('register_date') }}">
        </div>


        <div class="mb-3 col-sm-2">
            <button type="submit" class="btn btn-success">Lọc</button>
        </div>
    </form>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <!-- <th scope="col">Ảnh </th> -->
                <th scope="col">Tên</th>
                <th scope="col">Danh hiệu</th>
                <!--  <th scope="col">Note</th> -->
                <th scope="col">Bản khai</th>
                <th scope="col">Minh chứng</th>
                <th scope="col">Trạng thái</th>
                <th scope="col" style="width: 150px">Chứng nhận</th>
                <th scope="col">Nhận xét</th>
                <th scope="col">Ngày đăng ký</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @if($appellationsRegister->isEmpty())
            <tr>
                <td colspan="10" class="text-center text-danger">
                    Không tìm thấy kết quả phù hợp.
                </td>
            </tr>
            @else
            @foreach($appellationsRegister ?? [] as $key => $item)
            <tr>
                <th scope="row">{{ ($key + 1)  }}</th>
                <!--  <td>
                        <img src="{{ pare_url_file($item->appellation->avatar ?? "") }}" style="width: 100px" alt="">
                    </td> -->
                <td>{{ $item->name }}</td>
                <td>{{ $item->appellation->name ?? "..." }}</td>
                <!--   <td>{{ $item->appellation->note ?? "..." }}</td> -->
                <td>
                    <a href="{{ pare_url_file($item->file) }}" download="">Tải xuống</a>
                </td>
                <td>
                    @if (!empty($item->proof))
                    <a href="{{ pare_url_file($item->proof) }}" download="{{ $item->proof }}">Tải xuống</a>
                    @else
                    <span>Không có file</span>
                    @endif
                </td>

                <td>
                    @if($item->status == 0)
                    <span class="badge bg-secondary text-dark">
                        {{ $item->getStatus($item->status)['name'] ?? '...' }}
                    </span>
                    @else
                    <span class="badge {{ $item->getStatus($item->status)['class'] ?? '' }} text-dark">
                        {{ $item->getStatus($item->status)['name'] ?? '...' }}
                    </span>
                    @endif


                </td>



                <td>
                    <a href="{{ asset('certificate/'.$item->certification) }}" view="">
                        <img src="{{ asset('certificate/'.$item->certification) }}" style="width: 100px" alt="">
                    </a>
                </td>
                <td>{{ $item->note }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                <td>
                    @if (!$item->status == 2 || !$item->status == -1)

                    <a href="{{ route('user.appellation_register.update', $item->id) }}"
                        class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o">Cập nhật</i></a>
                    <!-- <a href="{{ route('user.appellation_register.delete', $item->id) }}"
                               class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a> -->
                    @endif
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
@stop