<form method="POST" action="" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mb-3 col-sm-12">
            <label for="exampleInputEmail1" class="form-label">Tên danh hiệu</label>
            <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Tên" value="{{ $appellation->name ?? "" }}" required aria-describedby="emailHelp">
            @if ($errors->has('name'))
                <div id="emailHelp" class="form-text text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Đối tượng</label>
            <select name="type" class="form-control" id="">
                <option value="1" {{ ($appellation->type ?? 1) == 1 ? "selected" : "" }}>Sinh viên</option>
                <option value="2" {{ ($appellation->type ?? 1) == 2 ? "selected" : "" }}>Giảng viên</option>
                <!--<option value="3" {{ ($appellation->type ?? 1) == 3 ? "selected" : "" }}>Nhân viên</option> -->
            </select>
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Đợt thi đua</label>
            <input type="text" class="form-control" name="semesters_name" id="" placeholder="Tên đợt thi đua" value="{{ $appellation->semesters_name ?? "" }}" required aria-describedby="emailHelp">
             <!-- <select name="semester_id" class="form-control" id="">
                @foreach($semesters ?? [] as $item)
                    <option value="{{ $item->id }}" {{ ($appellation->semester_id ?? 1) == $item->id ? "selected" : "" }}>{{ $item->s_name }}</option>
                @endforeach
            </select> -->
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Ngày bắt đầu</label>
            <input type="date" name="time_start" id="time_start" class="form-control" value="{{ $appellation->time_start ?? "" }}">
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1" class="form-label">Ngày kết thúc</label>
            <input type="date" name="time_stop" id="time_stop" class="form-control" value="{{ $appellation->time_stop ?? "" }}" >
        </div>

<!--         <script type="text/javascript">
            function checkdate(){
                console.log("dang ktra");
                   var input = document.getElementById("time_start").value;
                    var time_start = new Date(input);
                     var input = document.getElementById("time_stop").value;
                    var time_stop = new Date(input);
                if (!time_start.isbefore(time_stop)) {
                    alert("Ngày sai")
                }
            }
        </script> -->
    </div>

    <div class="row">
        <div class="mb-3 col-sm-12">
            <label for="exampleInputEmail1" class="form-label">Mô tả</label>
            <textarea name="note" class="form-control" id="" cols="30" rows="3">{{ $appellation->note ?? ""  }}</textarea>
        </div>
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1"> Hình ảnh </label>
            <input type="file" class="filepond form-control" name="avatar" >
            @if (isset($appellation->avatar))
            <img src="{{ asset($appellation->avatar) }}" style="width: 200px;height: auto;margin-top: 20px;" alt="">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label for="exampleInputEmail1"> Quyết định </label>
            <input type="file" class="filepond form-control" name="rule" >
            @if (isset($appellation->rule))
                <a href="{{ asset($appellation->rule) }}" download="">{{ $appellation->rule }}</a>
            @endif
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save" ></i></button>
</form>
