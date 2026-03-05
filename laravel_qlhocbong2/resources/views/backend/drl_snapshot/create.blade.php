@extends('backend.layouts.backend_master')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Chốt điểm DRL</h1>
        <a href="{{ route('backend.drl_snapshot.index') }}" class="btn btn-outline-secondary">Trở về</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p class="text-muted">Chọn học kỳ và các hoạt động cần tổng hợp. Hệ thống sẽ tính trạng thái tham gia (đủ Vào+Ra / thiếu / không tham gia) và lưu vào bảng chốt. Sinh viên xem DRL chỉ đọc dữ liệu đã chốt.</p>
            <form action="{{ route('backend.drl_snapshot.create') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Mã học kỳ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="semester_key" placeholder="VD: 2024-2025-HK1" value="{{ old('semester_key') }}" required>
                    @if($errors->has('semester_key'))
                    <div class="form-text text-danger">{{ $errors->first('semester_key') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Chọn hoạt động tham gia vào kỳ này <span class="text-danger">*</span></label>
                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        @foreach($activities ?? [] as $a)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activity_ids[]" value="{{ $a->_id }}" id="act_{{ $a->_id }}">
                            <label class="form-check-label" for="act_{{ $a->_id }}">
                                {{ $a->name }} ({{ $a->time_start ? date('d/m/Y', strtotime($a->time_start)) : '-' }})
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @if($errors->has('activity_ids'))
                    <div class="form-text text-danger">{{ $errors->first('activity_ids') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Chốt điểm</button>
            </form>
        </div>
    </div>
</div>
@endsection
