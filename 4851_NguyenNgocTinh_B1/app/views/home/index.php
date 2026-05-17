<?php include 'app/views/shares/header.php'; ?>

<?php 
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>

<style>
    .hero-section {
        padding: 80px 0;
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.05), transparent),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.05), transparent);
        border-radius: 40px;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 25px;
        letter-spacing: -0.05em;
    }

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
    }

    .img-container {
        position: relative;
        height: 300px;
        overflow: hidden;
        background: #f8fafc;
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
        padding: 20px;
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
        padding: 6px 12px;
        border-radius: 10px;
        font-weight: 700;
        color: #6366f1;
        font-size: 0.85rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .section-title {
        font-weight: 800;
        margin-bottom: 30px;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    .cat-item {
        background: white;
        padding: 25px;
        border-radius: 24px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: var(--card-shadow);
        text-decoration: none;
        color: #1f2937;
        display: block;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .cat-item:hover {
        transform: translateY(-5px);
        border-color: #6366f1;
        color: #6366f1;
    }

    .cat-icon {
        font-size: 2rem;
        margin-bottom: 15px;
        display: block;
        background: #f3f4f6;
        width: 70px;
        height: 70px;
        line-height: 70px;
        border-radius: 20px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-add-cart-home {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-add-cart-home:hover {
        opacity: 0.9;
        transform: scale(1.03);
    }
</style>

<div class="hero-section text-center">
    <div class="container">
        <div class="badge bg-light text-primary border px-3 py-2 rounded-pill mb-4 fw-bold">
            ✨ NTECH STORE v1.1
        </div>
        <h1 class="hero-title">Mua sắm công nghệ <br><span class="text-primary" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Đỉnh cao.</span></h1>
        <p class="text-muted mx-auto mb-4" style="max-width: 600px;">Khám phá bộ sưu tập những sản phẩm công nghệ mới nhất, chất lượng nhất được tuyển chọn dành riêng cho bạn.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="btn btn-primary btn-lg px-4 rounded-4">
                Xem tất cả sản phẩm
            </a>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h2 class="section-title">Khám phá danh mục</h2>
    <div class="row g-4">
        <div class="col-6 col-md-3">
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index?category=Điện thoại" class="cat-item">
                <span class="cat-icon"><i class="fa-solid fa-mobile-screen-button"></i></span>
                <span class="fw-bold">Điện thoại</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index?category=Laptop" class="cat-item">
                <span class="cat-icon"><i class="fa-solid fa-laptop"></i></span>
                <span class="fw-bold">Laptop</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index?category=Phụ kiện" class="cat-item">
                <span class="cat-icon"><i class="fa-solid fa-keyboard"></i></span>
                <span class="fw-bold">Phụ kiện</span>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index?category=Máy tính bảng" class="cat-item">
                <span class="cat-icon"><i class="fa-solid fa-tablet-screen-button"></i></span>
                <span class="fw-bold">Máy tính bảng</span>
            </a>
        </div>
    </div>
</div>

<div class="container mb-5 mt-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="section-title">Sản phẩm mới nhất</h2>
            <p class="text-muted mb-0">Cập nhật nhanh nhất những xu hướng công nghệ</p>
        </div>
        <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="text-decoration-none fw-bold">Xem thêm <i class="fa-solid fa-chevron-right ms-1"></i></a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
        <?php if (empty($featuredProducts)): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Đang cập nhật sản phẩm...</p>
            </div>
        <?php else: ?>
            <?php foreach ($featuredProducts as $product): ?>
                <?php 
                    $imageUrl = $product->getImage() ? "/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/public/uploads/" . $product->getImage() : "https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80";
                ?>
                <div class="col">
                    <div class="product-card h-100 shadow-sm">
                        <div class="img-container">
                            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/show/<?php echo $product->getId(); ?>" class="w-100 h-100 d-block">
                                <div class="product-img-display" style="background-image: url('<?php echo $imageUrl; ?>');"></div>
                            </a>
                            <div class="price-badge">
                                <?php echo number_format($product->getPrice(), 0, ',', '.'); ?>đ
                            </div>
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2 text-center">
                                <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/show/<?php echo $product->getId(); ?>" class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product->getName()); ?>
                                </a>
                            </h5>
                            <p class="text-muted small mb-3 text-center"><?php echo htmlspecialchars($product->getDescription()); ?></p>
                            
                            <div class="d-flex gap-2">
                                <?php if ($isAdmin): ?>
                                    <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/edit/<?php echo $product->getId(); ?>" class="btn btn-dark w-100 rounded-3">Sửa</a>
                                <?php else: ?>
                                    <button onclick="addToCart(<?php echo $product->getId(); ?>, '<?php echo addslashes($product->getName()); ?>', <?php echo $product->getPrice(); ?>, '<?php echo $imageUrl; ?>')" class="btn-add-cart-home">
                                        <i class="fa-solid fa-cart-plus me-1"></i> Thêm vào giỏ
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
