@extends('backend.layouts.admin_master')

@section('content')
<div class="container">
    <h2>Xác thực OTP</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form action="{{ route('admin.verify.otp') }}" method="POST">
        @csrf
        <label>Mã OTP:</label>
        <input type="number" name="otp" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-3">Xác thực OTP</button>
    </form>
</div>
@endsection
