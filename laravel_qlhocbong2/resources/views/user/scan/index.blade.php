@extends('user.layouts.user_master')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body text-center p-4">
                    <h5 class="card-title">{{ $qr->activity->name ?? 'Hoạt động' }}</h5>
                    <p class="text-muted">{{ $typeLabel ?? 'Điểm danh' }}</p>

                    @if(!auth()->guard('web')->check())
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> Vui lòng đăng nhập để điểm danh.
                    </div>
                    <a href="{{ route('get_user.login') }}" class="btn btn-primary">Đăng nhập</a>
                    @elseif(!($hasRegistered ?? true))
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> Vui lòng đăng ký hoạt động trước khi quét mã điểm danh.
                    </div>
                    <a href="{{ route('user.activity.index') }}" class="btn btn-primary">Đăng ký hoạt động</a>
                    @elseif($alreadyScanned ?? false)
                    <div class="alert alert-info">
                        <i class="fa fa-check-circle"></i> Bạn đã điểm danh ({{ $typeLabel }}) cho hoạt động này.
                    </div>
                    <a href="{{ route('user.activity.index') }}" class="btn btn-primary">Về danh sách hoạt động</a>
                    @else
                    <p class="mb-3">Xác nhận điểm danh <strong>{{ $typeLabel }}</strong>?</p>
                    <form action="{{ route('user.scan.submit') }}" method="POST" class="d-inline" id="scanForm">
                        @csrf
                        <input type="hidden" name="token" value="{{ $qr->token ?? request('token') }}">
                        <input type="hidden" name="scanned_at" id="scannedAt" value="">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-check"></i> Xác nhận điểm danh
                        </button>
                    </form>
                    <div class="mt-3">
                        <a href="{{ route('user.activity.index') }}" class="btn btn-outline-secondary">Hủy</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if(auth()->guard('web')->check() && !($alreadyScanned ?? false) && ($hasRegistered ?? true))
<script>
(function(){
    var form = document.getElementById('scanForm');
    var input = document.getElementById('scannedAt');
    if (form && input) {
        var t = new Date();
        input.value = t.toISOString ? t.toISOString() : (t.getTime());
    }
})();
</script>
@endif
@endsection
