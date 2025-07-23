@extends('backend.layouts.backend_master')
@section('content')
<style>
    body,
    .welcome-card,
    .welcome-title,
    .welcome-desc {
        font-family: 'Poppins', Arial, Helvetica, sans-serif;
    }

    .welcome-bg {
        background: linear-gradient(135deg, #e3f0ff 0%, #b3c6f7 100%);
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        flex-direction: column;
    }

    .welcome-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 4px 32px rgba(26, 115, 232, 0.10), 0 1.5px 6px rgba(26, 115, 232, 0.04);
        padding: 3rem 2.5rem;
        max-width: 520px;
        margin: 2rem auto 1.5rem auto;
        text-align: center;
        animation: fadeInUp 0.8s cubic-bezier(.4, 2, .6, 1);
    }

    .welcome-icon {
        font-size: 4rem;
        color: #1a73e8;
        margin-bottom: 1.2rem;
        animation: bounce 1.5s infinite alternate;
    }

    .welcome-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a237e;
        margin-bottom: 1rem;
        letter-spacing: 1px;
    }

    .welcome-desc {
        font-size: 1.15rem;
        color: #3b4a6b;
        margin-bottom: 1.5rem;
    }

    .welcome-divider {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #1a73e8 0%, #2196f3 100%);
        border-radius: 2px;
        margin: 1.5rem auto;
        opacity: 0.7;
    }

    .quick-nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .quick-card {
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(26, 115, 232, 0.10);
        padding: 1.5rem 1.2rem;
        min-width: 170px;
        max-width: 200px;
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        border: none;
        outline: none;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #1a237e;
        font-weight: 500;
        font-size: 1.08rem;
        position: relative;
    }

    .quick-card .qicon {
        font-size: 2.2rem;
        margin-bottom: 0.7rem;
        color: #fff;
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 0 2px 8px rgba(26, 115, 232, 0.10);
    }

    .quick-card.student .qicon {
        background: linear-gradient(135deg, #1a73e8 0%, #2196f3 100%);
    }

    .quick-card.award .qicon {
        background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
    }

    .quick-card.register .qicon {
        background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
    }

    .quick-card.department .qicon {
        background: linear-gradient(135deg, #f953c6 0%, #b91d73 100%);
    }

    .quick-card.logout .qicon {
        background: linear-gradient(135deg, #e53935 0%, #e35d5b 100%);
    }

    .quick-card:hover {
        transform: translateY(-7px) scale(1.04);
        box-shadow: 0 8px 32px rgba(26, 115, 232, 0.13);
        color: #1565c0;
        text-decoration: none;
    }

    .quick-card .qtext {
        margin-top: 0.2rem;
    }

    .quick-card.admin .qicon {
        background: linear-gradient(135deg, #6078ea 0%, #17c4ff 100%);
    }

    .quick-card.faculty .qicon {
        background: linear-gradient(135deg, #ff6b6b 0%, #f6416c 100%);
    }




    @media (max-width: 900px) {
        .quick-nav {
            gap: 1rem;
        }

        .quick-card {
            min-width: 140px;
            max-width: 160px;
            font-size: 0.98rem;
        }
    }

    @media (max-width: 600px) {
        .welcome-card {
            padding: 1.5rem 0.5rem;
        }

        .welcome-title {
            font-size: 1.3rem;
        }

        .welcome-desc {
            font-size: 1rem;
        }

        .quick-nav {
            gap: 0.5rem;
        }

        .quick-card {
            min-width: 110px;
            max-width: 120px;
            font-size: 0.92rem;
            padding: 1rem 0.3rem;
        }

        .quick-card .qicon {
            font-size: 1.3rem;
            width: 36px;
            height: 36px;
        }
    }
</style>
<div class="welcome-bg">
    <div class="welcome-card">
        <div class="welcome-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="welcome-title">
            Xin chào {{ Auth::user()->name }}
        </div>
        <div class="welcome-divider"></div>
        <div class="welcome-desc">
            <span style="color:#1a73e8;font-weight:500;">Chúc bạn một ngày làm việc hiệu quả!</span>
        </div>
    </div>
    <div class="quick-nav">
        @if(isset($level) && $level == 0)
        <!-- Quản lý quản trị viên chỉ hiển thị cho admin trường -->
        <a href="{{ route('backend.account.index') }}" class="quick-card admin">
            <div class="qicon"><i class="fas fa-user-shield"></i></div>
            <div class="qtext">Quản lý quản trị viên</div>
        </a>
        @endif

        <a href="{{ route('backend.user.index') }}" class="quick-card student">
            <div class="qicon"><i class="fas fa-users"></i></div>
            <div class="qtext">Quản lý ứng viên</div>
        </a>
        @if(isset($level) && $level == 0)
        <!-- Quản lý khoa chỉ hiển thị cho admin trường -->
        <a href="{{ route('backend.department.index') }}" class="quick-card faculty">
            <div class="qicon"><i class="fas fa-school"></i></div>
            <div class="qtext">Quản lý khoa</div>
        </a>
        @endif


        <a href="{{ route('backend.appellation.index') }}" class="quick-card award">
            <div class="qicon"><i class="fas fa-award"></i></div>
            <div class="qtext">Danh hiệu</div>
        </a>
        <a href="{{ route('backend.appellation_register.index') }}" class="quick-card register">
            <div class="qicon"><i class="fas fa-file-alt"></i></div>
            <div class="qtext">Đăng ký danh hiệu</div>
        </a>
        <a href="{{ route('backend.dashboard') }}" class="quick-card department">
            <div class="qicon"><i class="fas fa-building"></i></div>
            <div class="qtext">Thống kê</div>
        </a>

    </div>

</div>
@endsection