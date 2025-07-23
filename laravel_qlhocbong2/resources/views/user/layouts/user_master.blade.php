<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Hệ thống Quản lý Học bổng</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets/favicon.ico') }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap)-->
    @toastr_css
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
            --sidebar-width: 250px;
        }

        /* body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
        } */
        body {
        position: relative;
        z-index: 0; /* Đảm bảo ::before không bị đẩy ra ngoài */
        font-family: 'Be Vietnam Pro', sans-serif;
        position: relative;
        overflow: hidden;
        background-image: url('{{ asset('backend/images/iuh-campus.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(165, 166, 167, 0.96) 0%, rgba(166, 195, 214, 0.67) 100%);
        z-index: -1;
    }

    /* Giữ cho mọi nội dung không bị che bởi ::before */

.navbar,
#page-content-wrapper {
    background: transparent !important;
}


        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        #sidebar-wrapper.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-heading2 {
            padding: 15px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin: 15px;
            border-radius: 10px;
        }

        .sidebar-heading2 .avatar {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 15px;
            display: block;
            transition: all 0.3s ease;
            object-fit: cover;
        }

        .sidebar-heading2 .user-name {
            font-size: 1rem;
            font-weight: 500;
            margin-top: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .list-group {
            padding: 1rem 0.5rem;
        }

        .list-group-item {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            padding: 0.8rem 1rem;
            margin: 0.3rem 0;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .list-group-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(255, 255, 255, 0.1);
            transition: width 0.3s ease;
            z-index: 0;
        }

        .list-group-item:hover {
            color: white;
            transform: translateX(5px);
        }

        .list-group-item:hover::before {
            width: 100%;
        }

        .list-group-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .list-group-item.active::before {
            width: 100%;
        }

        .list-group-item i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .list-group-item:hover i {
            transform: scale(1.1);
        }

        .list-group-item span {
            position: relative;
            z-index: 1;
        }

        /* Top Navigation */
        .navbar {
            background: white !important;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 0.5rem 1rem;
            position: fixed;
            top: 0;
            right: 0;
            width: calc(100% - var(--sidebar-width));
            z-index: 999;
            height: 80px;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar .container-fluid {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            border: 2px solid var(--primary-color);
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .navbar .logoiuh {
            height: 75px;
            margin-right: 1rem;
        }

        #sidebarToggle {
            background: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
        }

        #sidebarToggle:hover {
            transform: rotate(180deg);
        }

        /* Main Content */
        #page-content-wrapper {
            flex: 1;
            min-width: 0;
            background: var(--light-color);
            margin-left: var(--sidebar-width);
            padding-top: 80px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .container-fluid {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Dropdown Menu */
        .dropdown-toggle {
            color: var(--dark-color) !important;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-toggle i {
            font-size: 1.2rem;
            color: var(--dark-color);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 8px;
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 0.6rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            color: var(--dark-color);
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            opacity: 0.1;
        }
        

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
                box-shadow: none;
            }

            #sidebar-wrapper.active {
                margin-left: 0;
                box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            }

            .navbar {
                width: 100%;
                left: 0;
            }

            .user-info {
                display: none;
            }

            .user-avatar {
                width: 35px;
                height: 35px;
            }

            #page-content-wrapper {
                margin-left: 0;
                min-width: 100%;
            }

            .container-fluid {
                padding: 1rem;
            }

            .sidebar-heading2 {
                margin: 10px;
            }

            .sidebar-heading2 .avatar {
                width: 70px;
                height: 70px;
            }

            .list-group-item {
                padding: 0.7rem 0.8rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #224abe;
        }

        /* When sidebar is hidden */
        #wrapper.sidebar-hidden #sidebar-wrapper {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        #wrapper.sidebar-hidden #page-content-wrapper {
            margin-left: 0;
        }

        #wrapper.sidebar-hidden .navbar {
            width: 100%;
            left: 0;
        }

        #wrapper.sidebar-hidden .container-fluid {
            max-width: 1200px;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end" id="sidebar-wrapper">
            <div class="list-group list-group-flush">
                @foreach(config('sidebar_user') as $item)
                @php
                $isActive = in_array(\Request::route()->getName(), $item['active_routes'] ?? []);
                @endphp
                <a class="list-group-item list-group-item-action {{ $isActive ? 'active' : '' }}"
                    href="{{ $item['route'] ? route($item['route']) : '#' }}">
                    <i class="fa {{ $item['icon'] ?? 'fa-circle' }} me-2"></i>
                    {{ $item['name'] }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light border-bottom">
                <div class="container-fluid">
                    <div class="navbar-left">
                        <button class="btn" id="sidebarToggle">
                            <i class="fa fa-bars"></i>
                        </button>
                        <img class="logoiuh" src="/images/Logo_IUH.png" alt="IUH Logo">
                    </div>
                    
                    <div class="navbar-right">
                        <div class="user-profile">
                            <img 
                            class="user-avatar" 
                            src="{{ $user->avatar ? pare_url_file($user->avatar) : asset('images/default-avatar.png') }}" 
                            alt="Ảnh đại diện">
                            <div class="user-info">
                                <span class="user-name">{{ get_data_user('web','name') }}</span>
                                <span class="user-role">{{ ($user->type ?? 1) == 1 ? 'Sinh viên' : 'Giảng viên' }}</span>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" 
                                href="#" id="navbarDropdown" 
                                role="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                <i class="fa fa-cog"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.index') }}">
                                        <i class="fa fa-user"></i>Cập nhật thông tin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('get_user.logout') }}">
                                        <i class="fa fa-sign-out"></i>Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page content-->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    @jquery
    @toastr_js
    @toastr_render

    <script>
        // Toggle sidebar with smooth animation
        document.getElementById("sidebarToggle").addEventListener("click", function(e) {
            e.preventDefault();
            const wrapper = document.getElementById("wrapper");
            const sidebar = document.getElementById("sidebar-wrapper");
            
            wrapper.classList.toggle("sidebar-hidden");
            
            // Add overlay when sidebar is active on mobile
            if (window.innerWidth <= 768) {
                if (!wrapper.classList.contains("sidebar-hidden")) {
                    const overlay = document.createElement("div");
                    overlay.className = "sidebar-overlay";
                    overlay.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: rgba(0, 0, 0, 0.5);
                        z-index: 999;
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    `;
                    document.body.appendChild(overlay);
                    setTimeout(() => overlay.style.opacity = "1", 10);
                    
                    overlay.addEventListener("click", function() {
                        wrapper.classList.add("sidebar-hidden");
                        overlay.style.opacity = "0";
                        setTimeout(() => overlay.remove(), 300);
                    });
                } else {
                    const overlay = document.querySelector(".sidebar-overlay");
                    if (overlay) {
                        overlay.style.opacity = "0";
                        setTimeout(() => overlay.remove(), 300);
                    }
                }
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener("click", function(e) {
            const wrapper = document.getElementById("wrapper");
            const sidebar = document.getElementById("sidebar-wrapper");
            const toggle = document.getElementById("sidebarToggle");
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggle.contains(e.target) && 
                !wrapper.classList.contains("sidebar-hidden")) {
                wrapper.classList.add("sidebar-hidden");
                const overlay = document.querySelector(".sidebar-overlay");
                if (overlay) {
                    overlay.style.opacity = "0";
                    setTimeout(() => overlay.remove(), 300);
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const wrapper = document.getElementById("wrapper");
            if (window.innerWidth > 768) {
                wrapper.classList.remove("sidebar-hidden");
            }
        });
    </script>
</body>

</html>