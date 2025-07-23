<form method="POST" action="" autocomplete="off">
    @csrf
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Tên" value="{{ $admin->name ?? "" }}" required aria-describedby="emailHelp">
            @if ($errors->has('name'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Vai trò Admin</label>
            <select name="level" class="form-control" id="">
                <option value="0">Admin Trường</option>
                @foreach($departments ?? [] as $item)
                <option value="{{ $item->id }}" {{ ($admin->level ?? 0) == $item->id ? "selected" : "" }}>{{ $item->d_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" value="{{ $admin->email ?? "" }}" required aria-describedby="emailHelp">
            @if ($errors->has('email'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="*******" {{ isset($admin) ? '' : 'required' }} aria-describedby="emailHelp">
            @if ($errors->has('password'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Số điện thoại</label>
            <input
                type="text"
                class="form-control"
                name="phone"
                placeholder="Số điện thoại"
                value="{{ $admin->phone ?? '' }}"
                required
                pattern="^0[0-9]{9}$"
                maxlength="10"
                title="Số điện thoại phải có 10 chữ số, bắt đầu bằng số 0">

            @if ($errors->has('phone'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('phone') }}</div>
            @endif
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="address" id="exampleInputEmail1" placeholder="Address" value="{{ $admin->address ?? "" }}" required aria-describedby="emailHelp">
            @if ($errors->has('address'))
            <div id="emailHelp" class="form-text text-danger">{{ $errors->first('address') }}</div>
            @endif
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
</form>