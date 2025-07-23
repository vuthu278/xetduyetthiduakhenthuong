@extends('backend.layouts.backend_master')
@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Cập nhật</h4>
        <a href="{{ route('backend.account.index') }}" title="Thêm mới" class="btn btn-danger">Trở về <i class="fa fa-undo"></i></a>
    </div>
    <div class="row">
        <div class="col-8">
            @include('backend.account.form')
        </div>
    </div>
@stop
<script>
    setTimeout(function () {
        const alert = document.getElementById('flash-alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
</script>

