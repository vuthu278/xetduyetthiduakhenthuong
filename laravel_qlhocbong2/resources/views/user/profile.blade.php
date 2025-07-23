@extends('user.layouts.user_master')
@section('content')
@if (session('success'))
<div id="flash-alert" class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
</div>
@endif
<div class="container py-4">
    <div class="row">
        <!-- Profile Info Card -->
        <div class="col-md-4 mb-4">
            <div class="card profile-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-wrapper mb-4">

                        <img
                            src="{{ $user->avatar ? pare_url_file($user->avatar) : asset('images/default-avatar.png') }}"
                            class="profile-avatar"
                            alt="Ảnh đại diện">
                        <div class="avatar-overlay">
                            <i class="fa fa-camera"></i>
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $user->name ?? "" }}</h4>
                    <p class="text-muted mb-3">
                        <i class="fa fa-user-circle me-2"></i>
                        {{ ($user->type ?? 1) == 1 ? 'Sinh viên' : 'Giảng viên' }}
                    </p>
                    <div class="profile-info">
                        <div class="info-item">
                            <i class="fa fa-id-card"></i>
                            <span>{{ $user->code ?? "" }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-envelope"></i>
                            <span>{{ $user->email ?? "" }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-phone"></i>
                            <span>{{ $user->phone ?? "" }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fa fa-map-marker"></i>
                            <span>{{ $user->address ?? "" }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Form Card -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-edit me-2"></i>Cập nhật thông tin</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name ?? "" }}" readonly required>
                                    <label for="name">Họ tên</label>
                                </div>
                                @if ($errors->has('name'))
                                <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="code" id="code" value="{{ $user->code ?? "" }}" readonly required>
                                    <label for="code">Mã số</label>
                                </div>
                                @if ($errors->has('code'))
                                <div class="invalid-feedback d-block">{{ $errors->first('code') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $user->email ?? "" }}" required>
                                    <label for="email">Email</label>
                                </div>
                                @if ($errors->has('email'))
                                <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" name="phone" id="phone" value="{{ $user->phone ?? "" }}" required>
                                    <label for="phone">Số điện thoại</label>
                                </div>
                                @if ($errors->has('phone'))
                                <div class="invalid-feedback d-block">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="address" id="address" value="{{ $user->address ?? "" }}" required>
                                    <label for="address">Địa chỉ</label>
                                </div>
                                @if ($errors->has('address'))
                                <div class="invalid-feedback d-block">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select name="type" class="form-select" disabled>
                                        <option value="1" {{ ($user->type ?? 1) == 1 ? "selected" : "" }}>Sinh viên</option>
                                        <option value="2" {{ ($user->type ?? 1) == 2 ? "selected" : "" }}>Giảng viên</option>
                                    </select>
                                    <label>Đối tượng</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="unit" id="unit"
                                        value="{{ optional($user->department)->d_name ?? 'Chưa cập nhật' }}" readonly>
                                    <label for="unit">Đơn vị</label>
                                </div>
                            </div>


                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ảnh đại diện</label>
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                            <small class="text-muted">Chọn ảnh mới để cập nhật ảnh đại diện</small>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .avatar-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-overlay i {
        color: #fff;
        font-size: 24px;
    }

    .profile-info {
        margin-top: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .info-item i {
        width: 30px;
        color: #0d6efd;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
        padding: 1rem;
    }

    .form-floating>.form-control,
    .form-floating>.form-select {
        height: calc(3.5rem + 2px);
        line-height: 1.25;
    }

    .form-floating>label {
        padding: 1rem 0.75rem;
    }

    .btn-primary {
        padding: 0.8rem 2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .profile-card {
            margin-bottom: 2rem;
        }

        .avatar-wrapper {
            width: 120px;
            height: 120px;
        }
    }
</style>
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