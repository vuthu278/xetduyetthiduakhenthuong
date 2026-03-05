<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR {{ $typeLabel ?? 'Điểm danh' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="text-center p-4 bg-white rounded shadow">
        <h4 class="mb-2">{{ $qr->activity->name ?? 'Hoạt động' }}</h4>
        <p class="text-muted mb-3">{{ $typeLabel ?? 'Quét để điểm danh' }}</p>
        <div class="mb-3">{!! $qrSvg !!}</div>
        <p class="small text-muted">Hết hạn: {{ $qr->expires_at ? $qr->expires_at->format('d/m/Y H:i') : '-' }}</p>
        <p class="small">Mở trình duyệt trên điện thoại và quét mã hoặc truy cập:<br><a href="{{ $scanUrl }}" target="_blank">{{ $scanUrl }}</a></p>
    </div>
</body>
</html>
