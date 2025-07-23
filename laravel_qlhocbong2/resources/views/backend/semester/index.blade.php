@extends('backend.layouts.backend_master')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Danh sách</h4>
        <a href="{{ route('backend.semester.create') }}" title="Thêm mới" class="btn btn-success">Thêm mới <i class="fa fa-plus"></i></a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Học kỳ</th>
                    <th scope="col">Ngày bắt đầu</th>
                    <th scope="col">Ngày kết thúc</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semesters ?? [] as $key => $item)
                    <tr>
                        <th scope="row">{{ ($key + 1)  }}</th>
                        <td>{{ $item->s_name }}</td>
                        <td>{{ $item->s_start }}</td>
                        <td>{{ $item->s_stop }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{ route('backend.semester.update', $item->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                            <a href="{{ route('backend.semester.delete', $item->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
