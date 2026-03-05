<form method="POST" action="{{ isset($activity) && $activity->_id ? route('backend.activity.update', $activity->getRouteKey()) : route('backend.activity.create') }}" autocomplete="off">
    @csrf
    <div class="row">
        <div class="mb-3 col-sm-12">
            <label class="form-label">Tên hoạt động</label>
            <input type="text" class="form-control" name="name" placeholder="Tên hoạt động" value="{{ $activity->name ?? '' }}" required>
            @if ($errors->has('name'))
                <div class="form-text text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label class="form-label">Đơn vị tổ chức</label>
            <select name="department_id" class="form-control">
                <option value="">-- Chọn đơn vị --</option>
                @foreach($departments ?? [] as $d)
                    <option value="{{ mongodb_id_string($d->_id) }}" {{ mongodb_id_string($activity->department_id ?? '') === mongodb_id_string($d->_id) ? 'selected' : '' }}>{{ $d->name ?? $d->d_name ?? 'Đơn vị #'.mongodb_id_string($d->_id) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 col-sm-6">
            <label class="form-label">Địa điểm</label>
            <input type="text" class="form-control" name="location" placeholder="Địa điểm" value="{{ $activity->location ?? '' }}">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label class="form-label">Số lượng tối đa (để trống = không giới hạn)</label>
            <input type="number" name="max_registrations" class="form-control" placeholder="VD: 100" value="{{ optional($activity)->max_registrations ?? '' }}" min="0">
            <small class="text-muted">Khi đủ số người đăng ký sẽ không cho đăng ký thêm</small>
        </div>
        <div class="mb-3 col-sm-6">
            <label class="form-label">Điểm cộng khi tham gia đầy đủ</label>
            <input type="number" name="points_per_activity" class="form-control" placeholder="Mặc định: 2" value="{{ optional($activity)->points_per_activity ?? 2 }}" min="0" step="0.5">
            <small class="text-muted">Điểm sinh viên nhận khi tham gia đủ (quét cả Vào và Ra). Tham gia một phần = 50% điểm.</small>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-6">
            <label class="form-label">Thời gian bắt đầu</label>
            <input type="datetime-local" name="time_start" class="form-control" value="{{ isset($activity->time_start) ? date('Y-m-d\TH:i', strtotime($activity->time_start)) : '' }}">
        </div>
        <div class="mb-3 col-sm-6">
            <label class="form-label">Thời gian kết thúc</label>
            <input type="datetime-local" name="time_stop" class="form-control" value="{{ isset($activity->time_stop) ? date('Y-m-d\TH:i', strtotime($activity->time_stop)) : '' }}">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-sm-12">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3">{{ $activity->description ?? '' }}</textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Lưu dữ liệu <i class="fa fa-save"></i></button>
</form>
