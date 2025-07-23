<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quản trị hệ thống | Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #0d47a1;
            --accent-color: #2196f3;
            --light-color: #f8f9fa;
            --dark-color: #1a237e;
            --success-color: #03a9f4;
            --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-image: url('{{ asset(' backend/images/iuh-campus.jpg') }}');
            /* background-image: url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2000&q=80'); */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 71, 161, 0.7);
            z-index: 0;
        }

        .login-container {
            width: 100%;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            min-height: 650px;
            position: relative;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .login-image {
            flex: 1;
            /* background: var(--gradient); */
            background-image: url('{{ asset(' backend/images/iuh-campus.jpg') }}');
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(4, 12, 18, 0.72) 0%, rgba(255, 255, 255, 0) 70%);
            animation: rotate 15s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .login-image-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .login-image h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-image p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .login-image .icon {
            font-size: 5rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .login-form {
            flex: 1;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h3 {
            color: var(--dark-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-control {
            height: 52px;
            padding: 0.75rem 1.25rem 0.75rem 3rem;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.15);
        }

        .input-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .btn-login {
            height: 52px;
            background: var(--gradient);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(33, 150, 243, 0.1);
            transform: rotate(45deg);
            transition: all 0.3s ease;
        }

        .btn-login:hover::after {
            left: 100%;
        }

        .alert {
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.75rem;
            border: none;
            display: flex;
            align-items: center;
        }

        .alert-danger {
            background: #e3f2fd;
            color: #1565c0;
            border-left: 4px solid #1565c0;
        }

        .alert i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .admin-badge {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            z-index: 3;
            box-shadow: 0 3px 10px rgba(26, 115, 232, 0.3);
        }

        .nav-buttons {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            display: flex;
            gap: 0.75rem;
            z-index: 3;
        }

        .nav-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .nav-btn.home {
            background: var(--success-color);
        }

        .nav-btn.home:hover {
            background: #0288d1;
        }

        .nav-btn.candidate {
            background: var(--dark-color);
        }

        .nav-btn.candidate:hover {
            background: #0d47a1;
        }

        .forgot-password {
            text-align: right;
            margin-top: -1rem;
            margin-bottom: 1.5rem;
        }

        .forgot-password a {
            color: var(--primary-color);
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .forgot-password a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .login-card {
                flex-direction: column;
                max-width: 600px;
            }

            .login-image {
                padding: 2.5rem;
                min-height: 250px;
            }

            .login-form {
                padding: 3rem 2.5rem;
            }

            .nav-buttons {
                position: relative;
                top: 0;
                right: 0;
                justify-content: center;
                margin-bottom: 1.5rem;
            }

            .admin-badge {
                position: relative;
                top: 0;
                left: 0;
                margin-bottom: 1rem;
                display: inline-block;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }

            .login-card {
                min-height: auto;
            }

            .login-form {
                padding: 2.5rem 1.5rem;
            }

            .login-image h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="admin-badge">
                <i class="fas fa-shield-alt"></i> Quản trị hệ thống
            </div>
            <div class="nav-buttons">
                <a href="{{ url('/') }}" class="nav-btn home">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
                <a href="{{ route('get_user.login') }}" class="nav-btn candidate">
                    <i class="fas fa-user-graduate"></i> Ứng viên
                </a>
            </div>
            <div class="login-image">
                <div class="login-image-content">
                    <div class="icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <h2>HỆ THỐNG QUẢN TRỊ</h2>
                    <p>Kết nối và trao cơ hội - Hệ thống quản lý thi đua - khen thưởng toàn diện dành cho các nhà quản trị</p>
                </div>
            </div>
            <div class="login-form">
                <div class="login-header">
                    <div class="login-logo">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Đăng nhập Quản trị</h3>
                    <p>Vui lòng nhập thông tin đăng nhập để tiếp tục</p>
                </div>

                @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('get_admin.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email quản trị" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="position-relative">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        </div>
                    </div>
                    <div class="forgot-password">
                        <a href="{{ route('admin.forgot.form') }}">
                            <i class="fas fa-question-circle"></i> Quên mật khẩu?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-login btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>