@extends('backend.layouts.backend_master')
@section('content')
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">{{ session('error') }}</div>
@endif
<div class="d-flex justify-content-between mt-3">
    <h4 class="">Cập nhật hoạt động</h4>
    <a href="{{ route('backend.activity.index') }}" class="btn btn-danger">Trở về <i class="fa fa-undo"></i></a>
</div>
<div class="row">
    <div class="col-8">
        @include('backend.activity.form')
    </div>
</div>
@endsection
