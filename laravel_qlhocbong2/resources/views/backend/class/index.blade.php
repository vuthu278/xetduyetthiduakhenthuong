@extends('backend.layouts.backend_master')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Lớp</h4>
        <a href="{{ route('backend.class.create') }}" title="Thêm mới" class="btn btn-success">Thêm mới <i class="fa fa-plus"></i></a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên lớp</th>
                    <th scope="col">Tên ngành</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($class ?? [] as $key => $item)
                    <tr>
                        <th scope="row">{{ ($key + 1)  }}</th>
                        <td>{{ $item->c_name }}</td>
                        <td>{{ $item->branch->b_name ?? "[N\A]" }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{ route('backend.class.update', $item->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                            <a href="{{ route('backend.class.delete', $item->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
