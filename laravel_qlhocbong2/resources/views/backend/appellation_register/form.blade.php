<form method="POST" action="" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mb-3 col-sm-4">
            <label for="exampleInputEmail1" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="name" {{ get_data_user('admins','level') == 1 ? 'readonly' : '' }} id="exampleInputEmail1" placeholder="Tên" value="{{ $user->name ?? "" }}" readonly required aria-describedby="emailHelp">
            @if ($errors->has('name'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-4">
            <label for="exampleInputEmail1" class="form-label">Mã số</label>
            <input type="text" class="form-control" name="code" {{ get_data_user('admins','level') == 1 ? 'readonly' : '' }} id="exampleInputEmail1" placeholder="MS" value="{{ $user->code ?? "" }}" required readonly aria-describedby="emailHelp">
            @if ($errors->has('code'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('code') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-4">
            <label for="exampleInputEmail1" class="form-label">Đề xuất</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" {{ ($appellationRegister->is_suggest ?? 0) == 1 ? "checked" : "" }} name="is_suggest">
                <label class="form-check-label" for="inlineCheckbox1"></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" {{ get_data_user('admins','level') == 1 ? 'readonly' : '' }} id="exampleInputEmail1" placeholder="Email" value="{{ $user->email ?? "" }}" required readonly aria-describedby="emailHelp">
            @if ($errors->has('email'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">SĐT</label>
            <input type="number" class="form-control" name="phone" {{ get_data_user('admins','level') == 1 ? 'readonly' : '' }} id="exampleInputEmail1" placeholder="SĐT" value="{{ $user->phone ?? "" }}" required readonly aria-describedby="emailHelp">
            @if ($errors->has('phone'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('phone') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Danh hiệu</label>
            <input type="text" class="form-control" value="{{ $appellationRegister->appellation->name ?? '' }}" readonly>
            <input type="hidden" name="appellation_id" value="{{ $appellationRegister->appellation_id ?? '' }}">
        </div>

        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Trạng thái</label>
            <select name="status" class="form-control" id="">
                <option value="1" {{ ($appellationRegister->status ?? 1) == 1 ? "selected" : "" }}>Đã xem</option>
                <option value="2" {{ ($appellationRegister->status ?? 1) == 2 ? "selected" : "" }}>Được đề nghị xét xuyệt</option>
                <option value="-1" {{ ($appellationRegister->status ?? 1) == -1 ? "selected" : "" }}>Không được đề nghị xét duyệt</option>
                @if( get_data_user('admins','level') == 0)
                <option value="3" {{ ($appellationRegister->status ?? 1) == 3 ? "selected" : "" }}>Đạt danh hiệu</option>
                <option value="4" {{ ($appellationRegister->status ?? 1) == 4 ? "selected" : "" }}>Không đạt danh hiệu</option>
                @endif
            </select>
        </div>

    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1"> Bản khai </label>
            <!--  <input type="file" class="filepond form-control" name="file" readonly> -->
            @if (isset($appellationRegister) && $appellationRegister->file)
            <p>File hiện tại : <a href="{{ pare_url_file($appellationRegister->file) }}" download="">{{ $appellationRegister->file }}</a></p>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1">Minh chứng</label>
            @if (isset($appellationRegister) && $appellationRegister->proof)
            <p>File hiện tại: <a href="{{ pare_url_file($appellationRegister->proof) }}" download="">{{ $appellationRegister->proof }}</a></p>
            @else
            <p>Không có file minh chứng</p>
            @endif
        </div>


        <!-- <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1"> Chứng nhận </label>
            <input type="file" class="filepond form-control" name="certification" >
            @if (isset($appellationRegister) && $appellationRegister->certification)
                <p>File : <a href="{{ pare_url_file($appellationRegister->certification) }}" download="">{{ $appellationRegister->certification }}</a></p>
            @endif
        </div> -->
    </div>
    <div class="row">

        <div class="mb-3 col-sm-12">
            <label for="exampleInputEmail1" class="form-label">Ghi chú</label>
            <textarea name="note" class="form-control" id="" cols="30" placeholder="Tiêu chuẩn:..." rows="3">{{ $appellationRegister->note }}</textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
</form>