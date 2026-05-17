<?php include 'app/views/shares/header.php'; ?>

<?php 
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>

<style>
    .product-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: var(--card-shadow);
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .img-container {
        position: relative;
        height: 300px;
        background: #f8fafc;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img-display {
        width: 100%;
        height: 100%;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 25px;
        background-origin: content-box;
    }

    .product-card:hover .product-img-display {
        transform: scale(1.08);
    }

    .price-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        padding: 8px 15px;
        border-radius: 12px;
        font-weight: 700;
        color: #6366f1;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        z-index: 2;
    }

    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(99, 102, 241, 0.15);
        color: #6366f1;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }

    .card-content {
        padding: 24px;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #111827;
    }

    .product-desc {
        color: #6b7280;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 20px;
        height: 45px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .action-btns {
        display: flex;
        gap: 10px;
    }

    .btn-action {
        flex: 1;
        padding: 10px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s;
        text-align: center;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-edit {
        background: #f3f4f6;
        color: #4b5563;
    }

    .btn-edit:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-del {
        background: #fee2e2;
        color: #ef4444;
        border: none;
    }

    .btn-del:hover {
        background: #fecaca;
        color: #dc2626;
    }

    .btn-add-cart {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-add-cart:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }

    .search-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: var(--card-shadow);
        margin-bottom: 40px;
    }
</style>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Khám phá sản phẩm</h1>
        <p class="text-muted mb-0">Quản lý kho hàng của bạn một cách chuyên nghiệp</p>
    </div>
    <?php if ($isAdmin): ?>
    <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/add" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Thêm sản phẩm
    </a>
    <?php endif; ?>
</div>

<div class="search-card">
    <form id="filterForm" action="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label text-muted small fw-bold">TÌM KIẾM TÊN</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control bg-light border-0" placeholder="Nhập tên sản phẩm..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" oninput="debouncedSubmit()">
            </div>
        </div>
        <div class="col-md-2">
            <label class="form-label text-muted small fw-bold">DANH MỤC</label>
            <select name="category" class="form-select bg-light border-0" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?php echo $cat; ?>" <?php echo ($_GET['category'] ?? '') == $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label text-muted small fw-bold">GIÁ TỪ</label>
            <input type="number" name="min_price" class="form-control bg-light border-0" placeholder="Min" value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>" oninput="debouncedSubmit()">
        </div>
        <div class="col-md-2">
            <label class="form-label text-muted small fw-bold">ĐẾN</label>
            <input type="number" name="max_price" class="form-control bg-light border-0" placeholder="Max" value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>" oninput="debouncedSubmit()">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="btn btn-outline-secondary w-100 rounded-3 border-0 bg-light text-muted">
                <i class="fa-solid fa-rotate-left me-2"></i> Reset
            </a>
        </div>
    </form>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
    <?php if (empty($products)): ?>
        <div class="col-12 text-center py-5">
            <div class="mb-4 text-muted"><i class="fa-solid fa-box-open fa-4x"></i></div>
            <h3>Không tìm thấy sản phẩm</h3>
            <p>Thử thay đổi bộ lọc hoặc thêm sản phẩm mới!</p>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <?php 
                $imageUrl = $product->getImage() ? "/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/public/uploads/" . $product->getImage() : "https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80";
            ?>
            <div class="col">
                <div class="product-card h-100">
                    <div class="img-container">
                        <div class="category-badge"><?php echo htmlspecialchars($product->getCategory()); ?></div>
                        <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/show/<?php echo $product->getId(); ?>" class="w-100 h-100 d-block">
                            <div class="product-img-display" style="background-image: url('<?php echo $imageUrl; ?>');"></div>
                        </a>
                        <div class="price-badge">
                            <?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ
                        </div>
                    </div>
                    <div class="card-content">
                        <h3 class="product-title">
                            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/show/<?php echo $product->getId(); ?>" class="text-decoration-none text-dark">
                                <?php echo htmlspecialchars($product->getName()); ?>
                            </a>
                        </h3>
                        <p class="product-desc"><?php echo htmlspecialchars($product->getDescription()); ?></p>
                        
                        <?php if ($isAdmin): ?>
                        <div class="action-btns border-top pt-3">
                            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/edit/<?php echo $product->getId(); ?>" class="btn-action btn-edit">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Sửa
                            </a>
                            <button onclick="confirmDelete(<?php echo $product->getId(); ?>)" class="btn-action btn-del">
                                <i class="fa-solid fa-trash me-1"></i> Xóa
                            </button>
                        </div>
                        <?php else: ?>
                        <div class="action-btns border-top pt-3">
                            <button onclick="addToCart(<?php echo $product->getId(); ?>, '<?php echo addslashes($product->getName()); ?>', <?php echo $product->getPrice(); ?>, '<?php echo $imageUrl; ?>')" class="btn-add-cart flex-fill">
                                <i class="fa-solid fa-cart-plus me-1"></i> Thêm vào giỏ
                            </button>
                            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/show/<?php echo $product->getId(); ?>" class="btn btn-light rounded-3 px-3">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    let timeout = null;
    function debouncedSubmit() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    }

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

    <?php if (isset($_SESSION['success_msg'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '<?php echo $_SESSION['success_msg']; ?>',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_msg'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '<?php echo $_SESSION['error_msg']; ?>',
            confirmButtonColor: '#6366f1'
        });
        <?php unset($_SESSION['error_msg']); ?>
    <?php endif; ?>
</script>

<?php include 'app/views/shares/footer.php'; ?>
