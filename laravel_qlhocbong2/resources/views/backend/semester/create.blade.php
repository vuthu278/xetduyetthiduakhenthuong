@extends('backend.layouts.backend_master')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Thêm mới</h4>
        <a href="{{ route('backend.semester.index') }}" title="Thêm mới" class="btn btn-danger">Trở về <i class="fa fa-undo"></i></a>
    </div>
    <div class="row">
        <div class="col-4">
            <form method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên học kỳ</label>
                    <input type="text" class="form-control" name="s_name" id="exampleInputEmail1" placeholder="Tên học kỳ" aria-describedby="emailHelp">
                    @if ($errors->has('s_name'))
                        <div id="emailHelp" class="form-text text-danger">{{ $errors->first('s_name') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" required name="s_start" id="exampleInputEmail1"  aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ngày kết thúc</label>
                    <input type="date" class="form-control" required name="s_stop" id="exampleInputEmail1"  aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới <i class="fa fa-save"></i></button>
            </form>
        </div>
    </div>
@stop
