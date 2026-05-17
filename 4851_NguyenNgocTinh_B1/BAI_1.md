# HƯỚNG DẪN XÂY DỰNG WEBSITE BÁN HÀNG PHP MVC

## Mục tiêu dự án

Xây dựng website bán hàng bằng PHP thuần theo mô hình MVC có các chức năng:

- Hiển thị danh sách sản phẩm
- Thêm sản phẩm
- Sửa sản phẩm
- Xóa sản phẩm
- Upload hình ảnh sản phẩm
- Hiển thị hình ảnh cùng thông tin sản phẩm
- Lưu dữ liệu bằng Session

---

# Công nghệ sử dụng

- PHP thuần
- HTML/CSS
- Bootstrap 5
- Session PHP
- MVC Pattern
- Upload file bằng PHP

---

# Cấu trúc thư mục

```text
webbanhang/
│
├── app/
│   ├── controllers/
│   │   └── ProductController.php
│   │
│   ├── models/
│   │   └── ProductModel.php
│   │
│   └── views/
│       └── product/
│           ├── list.php
│           ├── add.php
│           └── edit.php
│
├── uploads/
│
├── public/
│
└── index.php
```

---

# Yêu cầu giao diện

Sử dụng Bootstrap 5.

Mỗi sản phẩm phải hiển thị:

- Hình ảnh
- Tên sản phẩm
- Mô tả
- Giá
- Nút sửa
- Nút xóa

Danh sách sản phẩm hiển thị dạng card.

---

# Yêu cầu dữ liệu sản phẩm

Mỗi sản phẩm gồm:

```php
[
    'id',
    'name',
    'description',
    'price',
    'image'
]
```

Dữ liệu lưu trong:

```php
$_SESSION['products']
```

---

# Yêu cầu Router

File `index.php` phải xử lý routing dạng:

```text
/Product/index
/Product/add
/Product/save
/Product/edit/1
/Product/update
/Product/delete/1
```

---

# Yêu cầu ProductModel

Tạo class `ProductModel` gồm các hàm:

## Hàm lấy tất cả sản phẩm

```php
getProducts()
```

## Hàm lấy sản phẩm theo ID

```php
getProductById($id)
```

## Hàm thêm sản phẩm

```php
addProduct($name, $description, $price, $image)
```

## Hàm cập nhật sản phẩm

```php
updateProduct($id, $name, $description, $price, $image)
```

## Hàm xóa sản phẩm

```php
deleteProduct($id)
```

---

# Yêu cầu ProductController

Tạo class `ProductController`.

## Hàm index()

Hiển thị danh sách sản phẩm.

Load view:

```php
app/views/product/list.php
```

---

## Hàm add()

Hiển thị form thêm sản phẩm.

---

## Hàm save()

Xử lý:

- Lấy dữ liệu POST
- Upload hình ảnh
- Lưu sản phẩm vào Session
- Redirect về danh sách

---

## Hàm edit($id)

Hiển thị form sửa sản phẩm.

---

## Hàm update()

Xử lý:

- Update dữ liệu sản phẩm
- Nếu có upload ảnh mới thì thay ảnh cũ
- Nếu không upload thì giữ nguyên ảnh cũ

---

## Hàm delete($id)

Xóa sản phẩm theo ID.

---

# Yêu cầu upload hình ảnh

## Thư mục upload

```text
/uploads
```

---

## Điều kiện upload

Chỉ cho phép:

- jpg
- jpeg
- png
- gif

---

## Giới hạn dung lượng

Tối đa:

```text
5MB
```

---

## Khi upload thành công

Lưu đường dẫn ảnh vào Session.

Ví dụ:

```php
uploads/product1.jpg
```

---

# Yêu cầu giao diện list.php

Hiển thị danh sách sản phẩm dạng card Bootstrap.

Mỗi card gồm:

- Ảnh sản phẩm
- Tên sản phẩm
- Mô tả
- Giá
- Nút sửa
- Nút xóa

Ví dụ:

```html
<div class="card">
    <img src="uploads/abc.jpg">

    <div class="card-body">
        <h5>Tên sản phẩm</h5>

        <p>Mô tả</p>

        <p>100000 VNĐ</p>
    </div>
</div>
```

---

# Yêu cầu form thêm sản phẩm

File:

```text
app/views/product/add.php
```

Form phải có:

- Tên sản phẩm
- Mô tả
- Giá
- Upload hình ảnh

Form bắt buộc dùng:

```html
enctype="multipart/form-data"
```

---

# Yêu cầu form sửa sản phẩm

File:

```text
app/views/product/edit.php
```

Hiển thị:

- Thông tin cũ
- Hình ảnh hiện tại
- Cho phép upload ảnh mới

Nếu không upload ảnh mới:
- Giữ nguyên ảnh cũ

---

# Yêu cầu bảo mật cơ bản

Sử dụng:

```php
htmlspecialchars()
```

khi hiển thị dữ liệu.

---

# Yêu cầu UI

Sử dụng Bootstrap 5 CDN.

Navbar gồm:

- Danh sách sản phẩm
- Thêm sản phẩm

---

# Yêu cầu hoàn thiện

Project sau khi hoàn thành phải:

- Chạy được trên Laragon/XAMPP
- Có đầy đủ CRUD
- Upload và hiển thị ảnh hoạt động
- Không lỗi khi reload trang
- Có giao diện Bootstrap đẹp
- Có xác nhận khi xóa sản phẩm

---

# URL chạy project

```text
http://localhost
```

---

# Kết quả mong muốn

Website hoạt động giống một mini ecommerce admin:

- Quản lý sản phẩm
- Upload ảnh
- Hiển thị card sản phẩm
- CRUD đầy đủ
- MVC rõ ràng
- Code dễ đọc và dễ mở rộng