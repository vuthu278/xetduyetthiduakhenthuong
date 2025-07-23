@extends('backend.layouts.backend_master')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Cập nhật</h4>
        <a href="{{ route('backend.branch.index') }}" title="Thêm mới" class="btn btn-danger">Trở về <i class="fa fa-undo"></i></a>
    </div>
    <div class="row">
        <div class="col-4">
            <form method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên lớp</label>
                    <input type="text" class="form-control" name="c_name" value="{{ $class->c_name }}" id="exampleInputEmail1" placeholder="Tên lớp" aria-describedby="emailHelp">
                    @if ($errors->has('c_name'))
                        <div id="emailHelp" class="form-text text-danger">{{ $errors->first('c_name') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Chọn ngành</label>
                    <select name="branch_id" class="form-control" id="">
                        @foreach($branchs  ?? [] as $item)
                            <option value="{{ $item->id }}" {{ $class->branch_id == $item->id ? "selected" : "" }}>{{ $item->b_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới <i class="fa fa-save"></i></button>
            </form>
        </div>
    </div>
@stop
