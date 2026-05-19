<?php include 'app/views/shares/header.php'; ?>

<style>
    .product-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
    }

    .product-card-img {
        width: 100%;
        height: 220px;
        object-fit: contain;
        background: rgba(255, 255, 255, 0.02);
        padding: 1.5rem;
        border-bottom: 1px solid var(--glass-border);
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .product-card:hover .product-card-img {
        transform: scale(1.05);
    }

    .product-card-img-wrapper {
        overflow: hidden;
        border-radius: 16px 16px 0 0;
    }

    .no-image-placeholder {
        width: 100%;
        height: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.02);
        color: var(--text-muted);
        border-bottom: 1px solid var(--glass-border);
    }

    .product-card-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-card-title {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        letter-spacing: -0.2px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        min-height: 2.5em;
    }

    .product-card-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .product-card-title a:hover {
        color: var(--accent-color);
    }

    .product-card-price {
        font-family: var(--font-display);
        font-size: 1.25rem;
        font-weight: 700;
        color: #30d158;
        margin-bottom: 0.75rem;
        letter-spacing: -0.3px;
    }

    .product-card-category {
        margin-bottom: auto;
        padding-bottom: 0.75rem;
    }

    .product-card-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        padding-top: 0.75rem;
        border-top: 1px solid var(--glass-border);
    }

    /* Search box */
    .search-box {
        position: relative;
        max-width: 400px;
    }

    .search-box .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
        border-radius: 980px;
        padding: 0.6rem 1rem 0.6rem 2.8rem;
        transition: all 0.2s ease;
    }

    .search-box .form-control:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.12);
        color: var(--text-main);
    }

    .search-box .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.85rem;
        pointer-events: none;
    }

    [data-theme="light"] .search-box .form-control {
        background: rgba(0, 0, 0, 0.03);
    }

    [data-theme="light"] .search-box .form-control:focus {
        background: rgba(0, 0, 0, 0.05);
    }

    /* Pagination */
    .pagination-premium .page-link {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
        border-radius: 980px !important;
        padding: 0.4rem 0.85rem;
        margin: 0 3px;
        transition: all 0.15s ease;
        font-size: 0.85rem;
    }

    .pagination-premium .page-link:hover {
        background: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
    }

    .pagination-premium .page-item.active .page-link {
        background: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
    }

    .pagination-premium .page-item.disabled .page-link {
        opacity: 0.4;
    }

    /* Stats bar */
    .stats-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--glass-border);
        border-radius: 980px;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    [data-theme="light"] .stats-pill {
        background: rgba(0, 0, 0, 0.03);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--text-muted);
        opacity: 0.4;
        margin-bottom: 1.5rem;
    }

    /* Fade in animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-card {
        animation: fadeInUp 0.4s cubic-bezier(0.25, 1, 0.5, 1) both;
    }

    .product-card:nth-child(1) { animation-delay: 0.04s; }
    .product-card:nth-child(2) { animation-delay: 0.08s; }
    .product-card:nth-child(3) { animation-delay: 0.12s; }
    .product-card:nth-child(4) { animation-delay: 0.16s; }
    .product-card:nth-child(5) { animation-delay: 0.20s; }
    .product-card:nth-child(6) { animation-delay: 0.24s; }
    .product-card:nth-child(7) { animation-delay: 0.28s; }
    .product-card:nth-child(8) { animation-delay: 0.32s; }
</style>

<!-- Page Header -->
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h1 class="text-gradient fw-bold mb-1"><i class="fa-solid fa-boxes-stacked me-2 text-primary"></i>Sản phẩm</h1>
        <p class="text-muted mb-0">Khám phá các sản phẩm công nghệ hàng đầu</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <div class="d-flex gap-2 justify-content-md-end align-items-center flex-wrap">
            <div class="stats-pill">
                <i class="fa-solid fa-box-open"></i>
                <span><?php echo $totalProducts ?? count($products); ?> sản phẩm</span>
            </div>
            <?php if (SessionHelper::isLoggedIn()): ?>
                <a href="<?php echo BASE_URL; ?>/Product/add" class="btn btn-premium">
                    <i class="fa-solid fa-plus me-2"></i>Thêm sản phẩm
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="row mb-4">
    <div class="col-12">
        <form method="GET" action="<?php echo BASE_URL; ?>/Product" class="d-flex gap-3 align-items-center flex-wrap">
            <div class="search-box flex-grow-1" style="max-width: 450px;">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm, danh mục..." 
                       value="<?php echo htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-premium">
                <i class="fa-solid fa-search me-1"></i>Tìm
            </button>
            <?php if (!empty($keyword)): ?>
                <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-glass-secondary">
                    <i class="fa-solid fa-xmark me-1"></i>Xóa bộ lọc
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php if (!empty($keyword)): ?>
    <div class="mb-3">
        <span class="text-muted">Kết quả tìm kiếm cho: </span>
        <span class="badge-premium">"<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"</span>
        <span class="text-muted ms-2">(<?php echo $totalProducts; ?> kết quả)</span>
    </div>
<?php endif; ?>

<!-- Products Grid -->
<?php if (empty($products)): ?>
    <div class="glass-card empty-state">
        <i class="fa-solid fa-magnifying-glass d-block"></i>
        <h3 class="text-gradient fw-bold mb-2">Không tìm thấy sản phẩm</h3>
        <p class="text-muted mb-3">Thử tìm kiếm với từ khóa khác hoặc quay lại trang chủ.</p>
        <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-premium">
            <i class="fa-solid fa-arrow-left me-2"></i>Xem tất cả sản phẩm
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <!-- Product Image -->
                    <a href="<?php echo BASE_URL; ?>/Product/show/<?php echo $product->id; ?>" class="text-decoration-none">
                        <div class="product-card-img-wrapper">
                            <?php if (!empty($product->image) && file_exists($product->image)): ?>
                                <img src="<?php echo BASE_URL . '/' . $product->image; ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="product-card-img">
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    <i class="fa-regular fa-image fs-2 mb-2"></i>
                                    <small>Chưa có ảnh</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>

                    <!-- Product Info -->
                    <div class="product-card-body">
                        <div class="product-card-category">
                            <span class="badge-premium" style="font-size: 0.7rem;"><?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <h5 class="product-card-title">
                            <a href="<?php echo BASE_URL; ?>/Product/show/<?php echo $product->id; ?>"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a>
                        </h5>
                        <div class="product-card-price">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> <small style="font-size: 0.7em; font-weight: 400;">VND</small>
                        </div>

                        <!-- Actions -->
                        <div class="product-card-actions">
                            <a href="<?php echo BASE_URL; ?>/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-premium btn-sm flex-grow-1" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-cart-plus me-1"></i>Thêm giỏ
                            </a>
                            <?php if (SessionHelper::isLoggedIn()): ?>
                                <a href="<?php echo BASE_URL; ?>/Product/edit/<?php echo $product->id; ?>" class="btn btn-premium-warning btn-sm" style="font-size: 0.75rem; padding: 6px 10px;">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <button onclick="confirmDelete('<?php echo $product->id; ?>', '<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-premium-danger btn-sm" style="font-size: 0.75rem; padding: 6px 10px;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <nav class="mt-5 d-flex justify-content-center">
            <ul class="pagination pagination-premium mb-0">
                <?php 
                $queryParams = !empty($keyword) ? '&search=' . urlencode($keyword) : '';
                ?>
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo BASE_URL; ?>/Product?page=<?php echo $page - 1; ?><?php echo $queryParams; ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="<?php echo BASE_URL; ?>/Product?page=<?php echo $i; ?><?php echo $queryParams; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo BASE_URL; ?>/Product?page=<?php echo $page + 1; ?><?php echo $queryParams; ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<script>
function confirmDelete(id, name) {
    const currentTheme = localStorage.getItem('theme') || 'dark';
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: "Sản phẩm '" + name + "' sẽ bị xóa vĩnh viễn!",
        icon: 'warning',
        showCancelButton: true,
        background: currentTheme === 'light' ? '#ffffff' : '#1d1d1f',
        color: currentTheme === 'light' ? '#1d1d1f' : '#f5f5f7',
        confirmButtonColor: '#ff453a',
        cancelButtonColor: '#0071e3',
        confirmButtonText: '<i class="fa-solid fa-trash me-2"></i>Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?php echo BASE_URL; ?>/Product/delete/' + id;
        }
    })
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
