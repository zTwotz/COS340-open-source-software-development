# Môn học: Phát triển Phần mềm Mã nguồn mở (COS340) 📚💻
> **Sinh viên thực hiện:** Nguyễn Ngọc Tịnh  
> **MSSV:** 4851  
> **Trường:** Đại học Công nghệ TP.HCM (HUTECH)  
> **Repository:** [COS340-open-source-software-development](https://github.com/zTwotz/COS340-open-source-software-development)

---

## 🌟 Giới thiệu Chung
Chào mừng bạn đến với kho lưu trữ bài tập và đồ án thực hành cho môn học **Phát triển phần mềm mã nguồn mở** của tôi. Kho lưu trữ này ghi nhận toàn bộ quá trình học tập, hoàn thiện các bài thực hành và xây dựng sản phẩm hoàn chỉnh thông qua 6 Sprints từ cơ bản đến nâng cao.

---

## 📂 Các Dự án & Thành phần trong Kho lưu trữ

Repository này bao gồm 2 dự án thực hành chính cùng các tài nguyên định hướng phát triển bài học:

### 1. 🚀 Dự án Chính: NTECH STORE ([4851_NguyenNgocTinh_WebsiteBanHang](file:///d:/laragon/www/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_WebsiteBanHang))
Đây là website bán hàng linh kiện máy tính hoàn chỉnh và chuyên nghiệp, được tích hợp đầy đủ công nghệ hiện đại thông qua 6 Sprints:
- **Kiến trúc**: MVC (Model - View - Controller) chuẩn trong PHP.
- **Tính năng nổi bật**:
  - Giao diện **Apple Premium Design (Liquid Glass UI)** cực kỳ hiện đại, hỗ trợ chuyển đổi Dark/Light mode và SweetAlert2.
  - CRUD Danh mục & Sản phẩm, lưu trữ hình ảnh sản phẩm.
  - Quản lý **Giỏ hàng & Luồng Thanh toán** (ghi nhận hóa đơn và chi tiết hóa đơn vào CSDL MySQL).
  - Đăng ký, đăng nhập bảo mật (mật khẩu băm `BCRYPT`, quản lý phiên làm việc).
  - Hệ thống **RESTful API** tương tác dữ liệu dạng JSON.
  - Bảo mật kết nối API bằng cơ chế **JSON Web Token (JWT)** thông qua thư viện `firebase/php-jwt`.
- **Xem chi tiết tài liệu hướng dẫn và cấu trúc riêng tại**: [Xem README dự án chính](file:///d:/laragon/www/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_WebsiteBanHang/README.md).

### 2. 📝 Dự án Cơ bản: Practice Sprint 1 ([4851_NguyenNgocTinh_B1](file:///d:/laragon/www/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1))
Dự án cơ sở thực hiện trong Sprint đầu tiên nhằm tiếp cận và làm quen với cấu trúc thư mục MVC và xử lý lưu trữ dữ liệu thông qua Sessions của PHP (trước khi kết nối với Cơ sở dữ liệu vật lý MySQL).

### 3. 📑 Tài liệu định hướng & Kế hoạch
- **[TAI_LIEU.md](file:///d:/laragon/www/4851_NguyenNgocTinh_PTPM_MNM/TAI_LIEU.md)**: File tài liệu chứa toàn bộ yêu cầu, đề bài và mẫu cấu trúc lớp, phương thức của 6 bài học lớn trên trường.
- **[Sprint.md](file:///d:/laragon/www/4851_NguyenNgocTinh_PTPM_MNM/Sprint.md)**: File theo dõi tiến độ công việc chia nhỏ cho từng Sprint từ Sprint 1 đến Sprint 6 (Tất cả đã hoàn thành `[x]`).

---

## 🛠️ Yêu cầu Hệ thống
- **PHP**: Phiên bản 8.3 trở lên.
- **Cơ sở dữ liệu**: MySQL 8.0 trở lên.
- **Công cụ Server**: Laragon hoặc XAMPP.
- **Quản lý thư viện**: Composer.

---

## 🚀 Hướng dẫn Cài đặt & Cấu hình nhanh
1. **Clone repository này về máy của bạn** (Ví dụ đặt vào thư mục `www` của Laragon):
   ```bash
   git clone https://github.com/zTwotz/COS340-open-source-software-development.git
   ```
2. **Thiết lập Cơ sở dữ liệu**:
   - Tạo mới database tên là `my_store` trên MySQL.
   - Import toàn bộ dữ liệu từ file [database.sql](file:///d:/laragon/www/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_WebsiteBanHang/database.sql) vào database `my_store`.
3. **Cài đặt thư viện JWT**:
   - Di chuyển vào thư mục dự án chính: `cd 4851_NguyenNgocTinh_WebsiteBanHang`
   - Chạy lệnh cài đặt: `composer install`
4. **Truy cập dự án chính**:
   - Truy cập qua URL local ảo: `http://4851-nguyenngoctinh-websitebanhang.test` hoặc đường dẫn thư mục Laragon.
   - Tài khoản đăng nhập mẫu: **Tên đăng nhập:** `admin` | **Mật khẩu:** `123456`

---
*Chúc bạn có quá trình trải nghiệm và học tập hiệu quả cùng repository Phát triển phần mềm mã nguồn mở này!* 🚀💻✨
