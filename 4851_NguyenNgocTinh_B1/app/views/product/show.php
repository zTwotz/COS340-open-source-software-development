<?php include 'app/views/shares/header.php'; ?>

<?php 
// Kiểm tra quyền Admin
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
$imageUrl = $product->getImage() ? "/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/public/uploads/" . $product->getImage() : "https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80";
?>

<style>
    .details-container {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        margin-top: 20px;
    }

    .details-img-box {
        background: #f8fafc;
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-height: 400px;
    }

    .details-img {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
        filter: drop-shadow(0 20px 30px rgba(0,0,0,0.1));
    }

    .details-content {
        padding: 60px;
    }

    .category-label {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 25px;
    }

    .product-desc {
        color: #4b5563;
        line-height: 1.8;
        font-size: 1.1rem;
        margin-bottom: 40px;
    }

    .btn-cart-large {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 18px 35px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }

    .btn-cart-large:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.4);
        color: white;
    }

    .admin-actions {
        background: #f8fafc;
        padding: 20px 30px;
        border-radius: 20px;
        margin-top: 40px;
        border: 1px dashed #e2e8f0;
    }
</style>

<div class="mb-4">
    <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="text-decoration-none text-muted fw-bold">
        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại danh sách
    </a>
</div>

<div class="details-container">
    <div class="row g-0">
        <div class="col-lg-6">
            <div class="details-img-box">
                <img src="<?php echo $imageUrl; ?>" class="details-img" alt="Product Image">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="details-content">
                <div class="category-label"><?php echo htmlspecialchars($product->getCategory()); ?></div>
                <h1 class="display-5 fw-extrabold mb-3"><?php echo htmlspecialchars($product->getName()); ?></h1>
                
                <div class="product-price">
                    <?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ
                </div>
                
                <div class="product-desc">
                    <?php echo nl2br(htmlspecialchars($product->getDescription())); ?>
                </div>

                <div class="d-flex gap-3">
                    <button onclick="addToCart(<?php echo $product->getId(); ?>, '<?php echo addslashes($product->getName()); ?>', <?php echo $product->getPrice(); ?>, '<?php echo $imageUrl; ?>')" class="btn-cart-large flex-grow-1">
                        <i class="fa-solid fa-cart-plus me-2"></i> THÊM VÀO GIỎ HÀNG
                    </button>
                </div>

                <?php if ($isAdmin): ?>
                <div class="admin-actions">
                    <div class="small fw-bold text-muted mb-3"><i class="fa-solid fa-user-shield me-2"></i> QUẢN TRỊ VIÊN</div>
                    <div class="d-flex gap-2">
                        <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/edit/<?php echo $product->getId(); ?>" class="btn btn-dark rounded-3 px-4">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Chỉnh sửa sản phẩm
                        </a>
                        <button onclick="confirmDelete(<?php echo $product->getId(); ?>)" class="btn btn-outline-danger rounded-3 px-4">
                            <i class="fa-solid fa-trash me-2"></i> Xóa
                        </button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Dữ liệu sản phẩm sẽ bị xóa vĩnh viễn!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Đúng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/delete/' + id;
            }
        })
    }
</script>

<?php include 'app/views/shares/footer.php'; ?>
