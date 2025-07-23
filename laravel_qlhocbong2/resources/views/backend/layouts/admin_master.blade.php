<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Quản trị hệ thống | IUH</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets/favicon.ico') }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap)-->
    @toastr_css
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        }

        #wrapper {
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin 0.25s ease-out;
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 220px;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1rem 1.25rem;
            font-size: 1rem;
            background: var(--gradient);
            color: white;
            font-weight: 500;
            border: none !important;
        }

        #sidebar-wrapper .sidebar-heading span {
            opacity: 0.8;
            font-size: 0.85rem;
        }

        #sidebar-wrapper .list-group {
            width: 220px;
        }

        #sidebar-wrapper .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            color: var(--dark-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            width: 100%;
        }

        #sidebar-wrapper .list-group-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: var(--gradient);
            opacity: 0.1;
            transition: all 0.3s ease;
        }

        #sidebar-wrapper .list-group-item:hover::before {
            width: 100%;
        }

        #sidebar-wrapper .list-group-item.active {
            background: var(--gradient);
            color: white;
            border: none;
            width: 100%;
        }

        #sidebar-wrapper .list-group-item.active::before {
            display: none;
            width: 100%;
        }

        #sidebar-wrapper .list-group-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        #sidebar-wrapper .list-group-item span {
            flex: 1;
        }

        #page-content-wrapper {
            min-width: 100vw;
            background: #f8f9fa;
        }

        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.5rem 1.25rem;
            height: 60px;
        }

        .navbar-brand img {
            height: 40px;
            transition: all 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.05);
        }

        #sidebarToggle {
            background: var(--gradient);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        #sidebarToggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            min-width: 200px;
            margin-top: 0.5rem;
        }

        .dropdown-menu::before {
            display: none;
        }

        .dropdown-item {
            padding: 0.5rem 1.25rem;
            color: var(--dark-color);
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .dropdown-item i {
            margin-right: 0.5rem;
            width: 18px;
            text-align: center;
            font-size: 1rem;
        }

        .nav-link {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
        }

        .nav-link i {
            font-size: 1rem;
            margin-right: 0.5rem;
        }

        .container-fluid {
            padding: 2rem;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
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
            background: var(--secondary-color);
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem;
            font-size: 1.25rem;
            line-height: 1;
            background-color: transparent;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
            color: var(--primary-color);
            display: none;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: none;
            position: relative;
            width: 24px;
            height: 24px;
            display: inline-block;
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 2px;
            background-color: currentColor;
            left: 0;
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before {
            top: 6px;
        }

        .navbar-toggler-icon::after {
            bottom: 6px;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            transform: rotate(45deg);
            top: 11px;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
            transform: rotate(-45deg);
            bottom: 11px;
        }

        @media (max-width: 991.98px) {
            .navbar-toggler {
                display: block;
            }
            
            .navbar-collapse {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 1rem;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                border-radius: 0.5rem;
                margin-top: 0.5rem;
                z-index: 1000;
            }

            .navbar-nav {
                padding: 0.5rem 0;
            }

            .nav-item {
                margin: 0.25rem 0;
            }

            .nav-link {
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
            }

            .nav-link:hover {
                background: var(--gradient);
                color: white;
            }

            .dropdown-menu {
                position: static !important;
                transform: none !important;
                box-shadow: none;
                border: 1px solid rgba(0,0,0,0.1);
                margin-top: 0.5rem;
            }
        }

        /* New styles for dropdown with icon above text */
        .nav-item.dropdown .dropdown-toggle {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.5rem 1rem;
        }

        .nav-item.dropdown .dropdown-toggle i {
            margin-right: 0;
            margin-bottom: 0.25rem;
            font-size: 1.25rem;
        }

        .nav-item.dropdown .dropdown-toggle::after {
            display: none;
        }

        .nav-item.dropdown .dropdown-menu {
            text-align: center;
        }

        .nav-item.dropdown .dropdown-item {
            flex-direction: column;
            text-align: center;
            padding: 0.75rem 1rem;
        }

        .nav-item.dropdown .dropdown-item i {
            margin-right: 0;
            margin-bottom: 0.25rem;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="border-end bg-white" id="sidebar-wrapper">
        <!-- Removed logo-container div -->
        <div class="sidebar-heading">
            <i class="fas fa-user-shield me-2">
                <a href="{{ route('backend.index') }}" style="color: white; text-decoration: none;">
            </i>
            {{ get_data_user('admins','name') }}
        </div>
        
        
    </div>

    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <img src="{{ asset('images/Logo_IUH.png') }}" class="mx-auto" style="height: 60px; object-fit: contain;" alt="IUH Logo">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ get_data_user('admins','name') }}</span>
                            </a>
                            <
                        </li>
                    </ul>
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
</body>
</html>