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
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }

    .current-img-wrapper {
        position: relative;
        display: inline-block;
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid #f3f4f6;
        margin-bottom: 15px;
        background: #fff;
        padding: 10px;
    }

    .current-img {
        max-height: 200px;
        display: block;
        object-fit: contain;
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
        font-weight: 700;
        box-shadow: 0 4px 14px 0 rgba(245, 158, 11, 0.39);
    }

    .btn-warning-custom:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        color: white;
    }

    #image-preview {
        max-width: 100%;
        max-height: 200px;
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
            <h1>Chỉnh sửa sản phẩm</h1>
            <p class="text-muted">Cập nhật thông tin mới nhất cho sản phẩm của bạn</p>
        </div>
        
        <div class="form-container">
        <h2 class="mb-4 fw-bold">Chỉnh sửa sản phẩm</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/edit/<?php echo $product->getId(); ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product->getName()); ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="form-label">Mô tả sản phẩm</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($product->getDescription()); ?></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="category" class="form-label">Danh mục sản phẩm</label>
                    <select class="form-control" id="category" name="category" required>
                        <?php 
                        $cats = ["Điện thoại", "Laptop", "Phụ kiện", "Máy tính bảng", "Khác"];
                        foreach($cats as $cat) {
                            $selected = ($product->getCategory() == $cat) ? 'selected' : '';
                            echo "<option value='$cat' $selected>$cat</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label">Giá bán (VNĐ)</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $product->getPrice(); ?>" step="1000" required>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Hình ảnh sản phẩm</label>
                    <div class="current-img-wrapper" id="current-img-container">
                        <?php if ($product->getImage()): ?>
                            <img src="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/public/uploads/<?php echo $product->getImage(); ?>" alt="Current" class="current-img">
                        <?php else: ?>
                            <div class="p-4 bg-light text-muted">Chưa có ảnh</div>
                        <?php endif; ?>
                    </div>
                    
                    <input type="file" class="form-control" id="image-input" name="image" accept="image/*">
                    <img id="image-preview" src="#" alt="Xem trước ảnh">
                    <small class="text-muted mt-2 d-block italic">* Tải lên ảnh mới nếu bạn muốn thay đổi.</small>
                </div>
                
                <div class="d-grid gap-3 pt-3">
                    <button type="submit" class="btn btn-warning-custom btn-lg">
                        <i class="fa-solid fa-check-circle me-2"></i> Lưu thay đổi
                    </button>
                    <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="btn btn-link text-muted text-decoration-none text-center">
                        Quay lại danh sách
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
            const currentImg = document.getElementById('current-img-container');
            
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            if(currentImg) currentImg.style.opacity = '0.3'; // Làm mờ ảnh cũ khi có ảnh mới
        }
    }
</script>

<?php include 'app/views/shares/footer.php'; ?>
