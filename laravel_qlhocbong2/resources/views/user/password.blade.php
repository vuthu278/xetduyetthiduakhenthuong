@extends('user.layouts.user_master')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <h4 class="">Cập nhật</h4>
    </div>
    <div class="row">
        <div class="col-8">
            <form method="POST" action="" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label for="exampleInputEmail1" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="*******" required aria-describedby="emailHelp">
                        @if ($errors->has('password'))
                            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
            </form>

        </div>
    </div>
@stop
