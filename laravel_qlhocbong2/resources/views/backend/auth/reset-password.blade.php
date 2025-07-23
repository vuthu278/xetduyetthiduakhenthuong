@extends('backend.layouts.admin_master')

@section('content')
<div class="container">
    <h2>Đặt lại mật khẩu</h2>

    {{-- Thêm hiển thị thông báo ở đây --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
    </div>
    @endif


    {{-- Form nhập mật khẩu mới --}}
    <form action="{{ route('admin.reset.password') }}" method="POST">
        @csrf
        <label>Mật khẩu mới:</label>
        <input type="password" name="password" class="form-control" required>
        <label>Nhập lại mật khẩu:</label>
        <input type="password" name="password_confirmation" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-3">Đổi mật khẩu</button>
    </form>
</div>


@endsection