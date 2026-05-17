<?php include 'app/views/shares/header.php'; ?>

<style>
    .form-container {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        border: 2px solid #f3f4f6;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .input-group-text {
        background: #f9fafb;
        border: 2px solid #f3f4f6;
        border-right: none;
        border-radius: 12px 0 0 12px;
        color: #6366f1;
        font-weight: 700;
    }

    .input-group .form-control {
        border-radius: 0 12px 12px 0;
    }

    .btn-lg {
        padding: 14px;
        font-size: 1.1rem;
    }

    #image-preview {
        max-width: 100%;
        max-height: 250px;
        border-radius: 16px;
        display: none;
        margin-top: 15px;
        border: 2px solid #f3f4f6;
        object-fit: contain;
        padding: 10px;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="page-header text-center mb-5">
            <h1>Tạo sản phẩm mới</h1>
            <p class="text-muted">Điền thông tin chi tiết để đưa sản phẩm lên kệ hàng</p>
        </div>
        
        <div class="form-container">
        <h2 class="mb-4 fw-bold">Thêm sản phẩm mới</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/add" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ví dụ: iPhone 15 Pro Max" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="form-label">Mô tả sản phẩm</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Nhập mô tả chi tiết sản phẩm..." required></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="category" class="form-label">Danh mục sản phẩm</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="Điện thoại">Điện thoại</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Phụ kiện">Phụ kiện</option>
                        <option value="Máy tính bảng">Máy tính bảng</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Giá bán (VNĐ)</label>
                        <div class="input-group">
                            <span class="input-group-text">đ</span>
                            <input type="number" class="form-control" id="price" name="price" step="1000" placeholder="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                        <input type="file" class="form-control" id="image-input" name="image" accept="image/*">
                        <img id="image-preview" src="#" alt="Xem trước ảnh">
                    </div>
                </div>
                
                <div class="d-grid gap-3 pt-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-cloud-arrow-up me-2"></i> Xuất bản sản phẩm
                    </button>
                    <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="btn btn-link text-muted text-decoration-none text-center">
                        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại danh sách
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Image Preview Logic
    document.getElementById('image-input').onchange = evt => {
        const [file] = document.getElementById('image-input').files;
        if (file) {
            const preview = document.getElementById('image-preview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>

<?php include 'app/views/shares/footer.php'; ?>
