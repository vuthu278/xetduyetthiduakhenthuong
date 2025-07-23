@extends('backend.layouts.admin_master')

@section('content')
<div class="container">
    <h2>Quên mật khẩu</h2>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    {{-- Form nhập email --}}
    <form action="{{ route('admin.forgot.sendOTP') }}" method="POST">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-3">Gửi mã OTP</button>
    </form>
</div>
@endsection