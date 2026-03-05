@extends('backend.layouts.backend_master')
@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mt-3 mb-4">
    <h4 class="mb-0">Cập nhật quản trị viên</h4>
    <a href="{{ route('backend.account.index') }}" class="btn btn-outline-secondary"><i class="fa fa-undo me-1"></i>Trở về</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('backend.account.update', mongodb_id_string($admin->_id ?? $admin->id)) }}" autocomplete="off">
                    @csrf
                    @include('backend.account.form', ['formFieldsOnly' => true])
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Lưu</button>
                        <a href="{{ route('backend.account.index') }}" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
setTimeout(function() {
    const alert = document.querySelector('.alert');
    if (alert) alert.classList.add('fade');
}, 4000);
</script>
@endsection

