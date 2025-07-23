<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page Đăng ký xét duyệt</title>
    
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2980b9;
            --accent: #e74c3c;
        }
        
        body {
            /* font-family: 'Poppins', sans-serif; */
            font-family: 'Be Vietnam Pro', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(161, 199, 224, 0.95) 0%, rgba(41, 128, 185, 0.95) 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .hero-section {
            position: relative;
            overflow: hidden;
            background-image: url('{{ asset('backend/images/iuh-campus.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(65, 74, 81, 0.5) 0%, rgba(41, 128, 185, 0.9) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .btn-primary {
            background: linear-gradient(45deg, #3498db, #2980b9);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #2980b9, #3498db);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .pattern-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .card-image {
            transition: all 0.3s ease;
        }

        .card-hover:hover .card-image {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="hero-gradient text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <a href="{{ url('/') }}" class="hover:opacity-90 transition">
                        <img src="{{ asset('backend/images/logo.png') }}" alt="IUH Logo" class="h-16">
                    </a>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">Hệ thống đăng ký xét duyệt thi đua khen thưởng</h1>
                        <p class="text-sm md:text-base opacity-90">Trường Đại học Công nghiệp TP.HCM</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section py-20">
        <div class="container mx-auto px-4">
            <div class="hero-content text-center max-w-4xl mx-auto">
            <div class="text-center px-4">
    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4 animate-fade-in">
        Trường Đại học Công nghiệp TP.HCM
    </h2>
    <p class="text-base md:text-lg lg:text-xl text-white opacity-90 mb-6 animate-fade-in">
        Đổi mới, nâng tầm cao mới – Năng động, hội nhập toàn cầu
    </p>
</div>
                <div class="floating">
                    <img src="{{ asset('backend/images/MuDaiHoc.png') }}" alt="Students" class="mx-auto h-64">
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access Section -->
    <section class="py-20 pattern-bg">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Truy cập nhanh hệ thống</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <a href="{{ asset('user')}}" class="card-hover rounded-2xl p-8 text-center overflow-hidden">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 transform transition-transform hover:scale-110">
                        <i class="fas fa-user-graduate text-3xl"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Ứng viên</h3>
                    <p class="text-gray-600 mb-4">Đăng ký xét duyệt danh hiệu dành cho Sinh viên và Giảng viên</p>
                    <span class="text-blue-600 font-medium inline-flex items-center">
                        Truy cập <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                </a>
                
                <!-- Card 2 -->
                <a href="{{ asset('admin')}}" class="card-hover rounded-2xl p-8 text-center overflow-hidden">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 transform transition-transform hover:scale-110">
                        <i class="fas fa-user-shield text-3xl"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Quản trị viên</h3>
                    <p class="text-gray-600 mb-4">Trang quản trị hệ thống dành cho Ban quản lý</p>
                    <span class="text-green-600 font-medium inline-flex items-center">
                        Truy cập <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                </a>
                
                <!-- Card 3 -->
                <a href="https://doantn.iuh.edu.vn/" target="_blank" class="card-hover rounded-2xl p-8 text-center overflow-hidden">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-red-100 flex items-center justify-center text-red-600 transform transition-transform hover:scale-110">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Đoàn Thanh niên</h3>
                    <p class="text-gray-600 mb-4">Trang thông tin chính thức của Đoàn Thanh niên IUH</p>
                    <span class="text-red-600 font-medium inline-flex items-center">
                        Truy cập <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                </a>
                
                <!-- Card 4 - Chatbot -->
                <a href="{{ url('/chatbot') }}" class="card-hover rounded-2xl p-8 text-center overflow-hidden">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 transform transition-transform hover:scale-110">
                        <i class="fas fa-robot text-3xl"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Chatbot Hỗ Trợ</h3>
                    <p class="text-gray-600 mb-4">Trợ lý ảo hỗ trợ giải đáp thắc mắc về thi đua khen thưởng</p>
                    <span class="text-purple-600 font-medium inline-flex items-center">
                        Truy cập <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Tính năng nổi bật</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 transform transition-transform hover:scale-110">
                        <i class="fas fa-bolt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Nhanh chóng</h3>
                    <p class="text-gray-600">Quy trình đăng ký trực tuyến đơn giản, tiết kiệm thời gian</p>
                </div>
                
                <div class="feature-card p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 transform transition-transform hover:scale-110">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Bảo mật</h3>
                    <p class="text-gray-600">Hệ thống bảo mật đa lớp, đảm bảo an toàn dữ liệu</p>
                </div>
                
                <div class="feature-card p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 transform transition-transform hover:scale-110">
                        <i class="fas fa-mobile-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Mọi lúc mọi nơi</h3>
                    <p class="text-gray-600">Tương thích với mọi thiết bị, truy cập mọi lúc mọi nơi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Về chúng tôi</h3>
                    <p class="text-gray-400">Hệ thống đăng ký xét duyệt thi đua khen thưởng Trường Đại học Công nghiệp TP.HCM</p>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Liên kết</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Trang chủ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Hướng dẫn sử dụng</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Liên hệ</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center"><i class="fas fa-map-marker-alt mr-2"></i> 12 Nguyễn Văn Bảo, Gò Vấp, TP.HCM</li>
                        <li class="flex items-center"><i class="fas fa-phone-alt mr-2"></i> (028) 3894 0390</li>
                        <li class="flex items-center"><i class="fas fa-envelope mr-2"></i> info@iuh.edu.vn</li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Kết nối</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-blue-600 transition transform hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-red-600 transition transform hover:scale-110">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-blue-400 transition transform hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>© 2023 Trường Đại học Công nghiệp TP.HCM. Bảo lưu mọi quyền.</p>
            </div>
        </div>
    </footer>
</body>
</html>