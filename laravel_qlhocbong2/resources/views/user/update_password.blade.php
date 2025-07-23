@extends('user.layouts.user_master')
@section('content')
@if (session('success'))
<div id="flash-alert" class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="d-flex justify-content-between mt-3">
    <h4 class="">Cập nhật</h4>
</div>
<div class="row">
    <div class="col-8">
        <form method="POST" action="{{ route('user.update_password') }}">
            @csrf
            <div class="row">
                <div class="mb-3 col-sm-6">
                    <label for="exampleInputEmail1" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="*******" required aria-describedby="emailHelp">
                    @if ($errors->has('password'))
                    <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                    @endif

                </div>
                <div class="mb-3 col-sm-6">
                    <label for="exampleInputEmail1" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="password_confirmation" id="exampleInputEmail1" placeholder="*******" required aria-describedby="emailHelp">
                    @if ($errors->has('password_confirmation'))
                    <div class="form-text text-danger">{{ $errors->first('password_confirmation') }}</div>
                    @endif


                </div>
            </div>
            <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
        </form>

    </div>
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