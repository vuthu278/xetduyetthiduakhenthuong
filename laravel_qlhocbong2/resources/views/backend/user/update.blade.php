@extends('backend.layouts.backend_master')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Cập nhật</h4>
        <a href="{{ route('backend.user.index') }}" title="Thêm mới" class="btn btn-danger">Trở về <i class="fa fa-undo"></i></a>
    </div>
    <div class="row">
        <div class="col-8">
            @include('backend.user.form')
        </div>
    </div>
@stop
