# 🚀 NTECH STORE - Hệ thống Quản lý & Bán hàng Công nghệ (v1.1)

Dự án này là một ứng dụng Web được xây dựng trên nền tảng **PHP MVC** thuần, tập trung vào việc quản lý kho hàng và trải nghiệm mua sắm hiện đại. Dự án được tối ưu hóa về giao diện (UI/UX) và tích hợp các tính năng bảo mật căn bản.

---

## 🛠 Công nghệ sử dụng
*   **Ngôn ngữ**: PHP 8.x (MVC Pattern)
*   **Dữ liệu**: JSON Persistence (Lưu trữ bền vững vào tệp `app/data.json`)
*   **Giao diện**: Bootstrap 5, Font Awesome 6, Google Fonts (Inter)
*   **Thư viện hỗ trợ**: SweetAlert2 (Thông báo), LocalStorage (Giỏ hàng)
*   **Thiết kế**: Phong cách Glassmorphism, Dark Mode, Responsive (Tương thích mọi thiết bị)

---

## ✨ Tính năng nổi bật

### 1. Quản lý sản phẩm (CRUD)
*   Thêm mới, Chỉnh sửa, Xóa sản phẩm với cơ chế lưu trữ JSON.
*   **Image Preview**: Xem trước ảnh ngay lập tức khi chọn file.
*   **Validation**: Chặn dữ liệu lỗi (giá âm, để trống, file không phải ảnh, file > 2MB).

### 2. Tìm kiếm & Lọc thông minh
*   **Real-time Filter**: Lọc theo Tên, Danh mục và Khoảng giá ngay khi đang nhập (không cần tải lại trang).
*   **Reset Filter**: Đưa bộ lọc về trạng thái ban đầu chỉ với 1 click.

### 3. Phân quyền người dùng (RBAC)
Hệ thống hỗ trợ 2 vai trò với tính năng **Quick Login** (Đăng nhập nhanh):
*   **Admin (`admin@gmail.com` / `123`)**: Toàn quyền quản trị kho hàng.
*   **User (`user@gmail.com` / `123`)**: Quyền khách hàng (Xem và mua sắm).
*   **Bảo mật**: Chặn truy cập trái phép vào các đường dẫn quản trị.

### 4. Giỏ hàng hiện đại (Shopping Cart)
*   Sử dụng **LocalStorage** để lưu trữ giỏ hàng (không làm nặng Server).
*   Tính năng: Thêm vào giỏ, Tăng/Giảm số lượng, Xóa món đồ, Tính tổng tiền thời gian thực.
*   **Auto-reset**: Giỏ hàng tự động xóa sạch khi Đăng nhập hoặc Đăng xuất để bảo mật.

### 5. Trải nghiệm người dùng (UX/UI)
*   **Dark/Light Mode**: Chuyển đổi giao diện sáng/tối linh hoạt.
*   **Product Details**: Trang chi tiết sản phẩm chuyên nghiệp.
*   **Landing Page**: Trang chủ bắt mắt với các danh mục và sản phẩm mới nhất.

---

## 📂 Cấu trúc thư mục
```text
/4851_NguyenNgocTinh_B1
├── app/
│   ├── controllers/    # Xử lý Logic (Product, Account, Home, Cart)
│   ├── models/         # Cấu trúc dữ liệu sản phẩm
│   ├── views/          # Giao diện người dùng (Sản phẩm, Giỏ hàng, Đăng nhập...)
│   └── data.json       # Cơ sở dữ liệu JSON
├── public/
│   └── uploads/        # Thư mục lưu trữ hình ảnh sản phẩm
├── index.php           # Front Controller (Cổng vào duy nhất)
└── .htaccess           # Cấu hình Rewrite URL sạch
```

---

## 🚀 Hướng dẫn cài đặt
1.  Sử dụng môi trường **Laragon** (hoặc XAMPP).
2.  Đặt thư mục dự án vào `www` hoặc `htdocs`.
3.  Cấu hình cổng chạy mặc định: **88** (http://localhost:88/4851_NguyenNgocTinh_B1).
4.  Đăng nhập bằng tài khoản Admin/User ở mục **Chọn vai trò đăng nhập** để trải nghiệm đầy đủ.

---
**Phát triển bởi**: Nguyễn Ngọc Tính - Bài 1 (PHP MVC v1.1)
