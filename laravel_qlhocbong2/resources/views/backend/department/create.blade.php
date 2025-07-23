@extends('backend.layouts.backend_master')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Thêm mới</h4>
        <a href="{{ route('backend.department.index') }}" title="Thêm mới" class="btn btn-danger">Trở về <i class="fa fa-undo"></i></a>
    </div>
    <div class="row">
        <div class="col-4">
            <form method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Mã khoa</label>
                    <input type="text" class="form-control" required name="d_code" id="exampleInputEmail1" placeholder="Mã khoa" aria-describedby="emailHelp" required pattern="[A-Z]+">
                    @if ($errors->has('d_code'))
                        <div id="emailHelp" class="form-text text-danger">{{ $errors->first('d_code') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên khoa</label>
                    <input type="text" class="form-control" name="d_name" id="exampleInputEmail1" placeholder="Tên khoa" aria-describedby="emailHelp">
                    @if ($errors->has('d_name'))
                        <div id="emailHelp" class="form-text text-danger">{{ $errors->first('d_name') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
            </form>
        </div>
    </div>
@stop
