# Hệ Thống Xét Duyệt Thi Đua Khen Thưởng

## Mô tả
Hệ thống quản lý và xét duyệt thi đua khen thưởng được xây dựng bằng Laravel framework, tích hợp chatbot AI để hỗ trợ người dùng.

## Tính năng chính
- **Quản lý tài khoản**: Hệ thống phân quyền admin và user
- **Quản lý danh hiệu**: CRUD các danh hiệu thi đua
- **Đăng ký danh hiệu**: Người dùng đăng ký danh hiệu thi đua
- **Xét duyệt**: Admin xét duyệt đăng ký
- **Chatbot AI**: Hỗ trợ tư vấn qua chat
- **Quản lý học bổng**: Hệ thống quản lý học bổng

## Công nghệ sử dụng
- **Backend**: Laravel 8+ (PHP)
- **Frontend**: Bootstrap 3, jQuery
- **Database**: MySQL
- **AI Chatbot**: Python với RAG (Retrieval-Augmented Generation)
- **Vector Database**: ChromaDB

## Cài đặt

### Yêu cầu hệ thống
- PHP >= 7.4
- Composer
- MySQL >= 5.7
- Python 3.8+ (cho chatbot)

### Cài đặt Laravel
```bash
cd laravel_qlhocbong2
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Cài đặt Chatbot
```bash
cd chatlinhtinh
pip install -r requirements.txt
python api.py
```

## Cấu trúc thư mục
```
├── laravel_qlhocbong2/          # Laravel application
│   ├── app/                     # Controllers, Models, Middleware
│   ├── resources/               # Views, CSS, JS
│   ├── routes/                  # Route definitions
│   └── database/                # Migrations, Seeders
├── chatlinhtinh/                # AI Chatbot system
│   ├── api.py                   # Chatbot API
│   ├── rag.py                   # RAG implementation
│   └── data/                    # Training data
└── vendor/                      # Composer dependencies
```

## Sử dụng
1. Truy cập hệ thống qua trình duyệt
2. Đăng nhập với tài khoản admin hoặc user
3. Sử dụng chatbot để được tư vấn
4. Quản lý danh hiệu và đăng ký thi đua

## Đóng góp
Mọi đóng góp đều được chào đón. Vui lòng tạo issue hoặc pull request.

## Giấy phép
Dự án này được phát hành dưới giấy phép MIT.
