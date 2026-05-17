<?php include 'app/views/shares/header.php'; ?>

<style>
    .detail-img-wrapper {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 350px;
        padding: 2rem;
    }

    .detail-img {
        width: 100%;
        max-height: 450px;
        object-fit: contain;
    }

    .detail-placeholder {
        color: var(--gray-48);
        text-align: center;
    }

    .info-pane {
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: center;
    }

    .detail-price {
        font-family: var(--font-display);
        font-size: 2.25rem;
        font-weight: 600;
        color: #30d158; /* Apple System Green */
        margin: 1rem 0;
        letter-spacing: -0.5px;
    }

    .detail-desc {
        color: rgba(255, 255, 255, 0.65);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        white-space: pre-line;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/Product" class="text-muted text-decoration-none">Sản phẩm</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?php echo htmlspecialchars($product->name); ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="glass-card">
    <div class="row g-5">
        <!-- Image Side -->
        <div class="col-md-5">
            <div class="detail-img-wrapper p-3">
                <?php if (!empty($product->image) && file_exists($product->image)): ?>
                    <img src="<?php echo BASE_URL . '/' . $product->image; ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="detail-img">
                <?php else: ?>
                    <div class="detail-placeholder">
                        <i class="fa-regular fa-image fs-1 mb-3"></i>
                        <h5>Sản phẩm chưa có hình ảnh</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Info Side -->
        <div class="col-md-7">
            <div class="info-pane">
                <div>
                    <span class="badge-premium mb-3 d-inline-block"><?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <h1 class="text-gradient fw-bold mb-2"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h1>
                
                <div class="detail-price">
                    <?php echo number_format($product->price, 0, ',', '.'); ?> <span style="font-size: 1.2rem;">VND</span>
                </div>
                
                <hr style="border-color: var(--glass-border);">
                
                <h5 class="fw-semibold text-white mb-2">Mô tả chi tiết:</h5>
                <p class="detail-desc">
                    <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-premium px-4 py-2">
                        <i class="fa-solid fa-cart-shopping me-2"></i>Thêm vào giỏ hàng
                    </a>
                    <a href="<?php echo BASE_URL; ?>/Product/edit/<?php echo $product->id; ?>" class="btn btn-premium-warning px-4 py-2">
                        <i class="fa-solid fa-pen-to-square me-2"></i>Chỉnh sửa sản phẩm
                    </a>
                    <button onclick="confirmDelete('<?php echo $product->id; ?>', '<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-premium-danger px-4 py-2">
                        <i class="fa-solid fa-trash-can me-2"></i>Xóa sản phẩm
                    </button>
                    <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-glass-secondary px-4 py-2">
                        <i class="fa-solid fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Sản phẩm '" + name + "' sẽ bị xóa vĩnh viễn khỏi hệ thống!",
        icon: 'warning',
        showCancelButton: true,
        background: '#1d1d1f',
        color: '#f5f5f7',
        confirmButtonColor: '#ff453a',
        cancelButtonColor: '#0071e3',
        confirmButtonText: '<i class="fa-solid fa-trash me-2"></i>Có, hãy xóa!',
        cancelButtonText: 'Hủy bỏ'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?php echo BASE_URL; ?>/Product/delete/' + id;
        }
    })
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
