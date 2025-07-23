<form method="POST" action="" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                value="{{ $user->name ?? '' }}" readonly required>
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Mã số</label>
            <input type="text" class="form-control" name="code" id="exampleInputEmail1"
                value="{{ $user->code ?? '' }}" readonly required>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                value="{{ $user->email ?? '' }}" readonly required>
        </div>
        <div class="mb-3 col-sm-6">
            <label for="phone" class="form-label">SĐT</label>
            <input type="text" class="form-control" name="phone" id="phone"
                value="{{ $user->phone ?? '' }}" readonly required>
        </div>

    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Danh hiệu</label>
            <input type="text" class="form-control"
                value="{{ $appellation->name ?? ($appellationRegister->appellation->name ?? '') }}" readonly>
            <input type="hidden" name="appellation_id"
                value="{{ $appellation->id ?? ($appellationRegister->appellation_id ?? '') }}">
        </div>

        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1"> Bản khai </label>
            <input type="file" class="filepond form-control" name="file" required>
            @if (isset($appellationRegister) && $appellationRegister->file)
            <p>File : <a href="{{ pare_url_file($appellationRegister->file) }}" download="">{{ $appellationRegister->file }}</a></p>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1"> Minh chứng </label>
            <input type="file" class="filepond form-control" name="proof" required>
            @if (isset($appellationRegister) && $appellationRegister->proof)
            <p>File :
                <a href="{{ pare_url_file($appellationRegister->proof) }}" download="{{ $appellationRegister->proof }}">
                    {{ $appellationRegister->proof }}
                </a>
            </p>
            @endif
        </div>


    </div>
    <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
</form>