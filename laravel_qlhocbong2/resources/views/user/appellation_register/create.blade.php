@extends('user.layouts.user_master')
@section('content')
<div class="row align-items-center mb-3">
    <div class="col-md-6 col-sm-12">
        <h4 class="mb-0">Đăng Ký Xét Duyệt Danh Hiệu</h4>
    </div>
    <div class="col-md-6 col-sm-12 text-md-end text-start mt-2 mt-md-0">
        <a href="{{ route('user.appellation.index') }}" class="btn btn-danger">
            Trở về <i class="fa fa-undo"></i>
        </a>
    </div>
</div>


<div class="row">
    <div class="col-8">
        @include('user.appellation_register.form')
    </div>
</div>
@stop