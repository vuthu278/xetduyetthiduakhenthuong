<form method="POST" action="" autocomplete="off">
    @csrf
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Tên" value="{{ $user->name ?? "" }}" required aria-describedby="emailHelp">
            @if ($errors->has('name'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Mã ứng viên</label>
            <input type="text"
                class="form-control"
                name="code"
                placeholder="Mã ứng viên"
                value="{{ $user->code ?? '' }}"
                required
                pattern="^[a-zA-Z0-9]+$"
                title="Chỉ nhập chữ và số, không có ký tự đặc biệt"
                aria-describedby="emailHelp">

            @if ($errors->has('code'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('code') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" value="{{ $user->email ?? "" }}" required aria-describedby="emailHelp">
            @if ($errors->has('email'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>
        @if (isset($user))
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="*******" {{ isset($user) ? '' : 'required' }} aria-describedby="emailHelp">
            @if ($errors->has('password'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>
        @endif
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Số điện thoại</label>
            <input type="text"
                class="form-control"
                name="phone"
                placeholder="Số điện thoại"
                value="{{ $user->phone ?? '' }}"
                required
                pattern="^0[0-9]{9}$"
                maxlength="10"
                title="Số điện thoại phải có 10 chữ số, bắt đầu bằng số 0"
                aria-describedby="emailHelp">

            @if ($errors->has('phone'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('phone') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="address" id="exampleInputEmail1" placeholder="Địa chỉ" value="{{ $user->address ?? "" }}" required aria-describedby="emailHelp">
            @if ($errors->has('address'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('address') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Đơn vị</label>
            <select name="department_id" class="form-control" id="">
                @foreach($departments ?? [] as $item)
                <option value="{{ $item->id }}" {{ ($user->department_id ?? 0) == $item->id ? "selected" : "" }}>{{ $item->d_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Đối tượng</label>
            <select name="type" class="form-control" id="">
                <option value="1" {{ ($user->type ?? 1) == 1 ? "selected" : "" }}>Sinh viên</option>
                <option value="2" {{ ($user->type ?? 1) == 2 ? "selected" : "" }}>Giảng viên</option>
                <!-- <option value="3" {{ ($user->type ?? 1) == 3 ? "selected" : "" }}>Nhân viên</option> -->
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
</form>