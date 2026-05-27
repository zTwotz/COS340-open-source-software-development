<?php include 'app/views/shares/header.php'; ?>

<style>
    .product-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 18px; /* rounded.lg */
        padding: 24px; /* spacing.lg */
        transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1), background-color 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: none; /* No shadow on card by default */
    }

    .product-card:hover {
        transform: translateY(-4px);
        background: var(--card-hover-bg);
    }

    .product-card-img-wrapper {
        border-radius: 8px; /* rounded.sm */
        overflow: hidden;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 200px;
        margin-bottom: 12px;
    }

    .product-card-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
        /* Signature product shadow under the product render resting on a surface */
        filter: drop-shadow(rgba(0, 0, 0, 0.22) 3px 5px 30px);
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .product-card:hover .product-card-img {
        transform: scale(1.03);
    }

    .no-image-placeholder {
        width: 100%;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.02);
        color: var(--text-muted);
        border-radius: 8px;
    }

    .product-card-body {
        padding: 0;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-card-title {
        font-family: var(--font-text);
        font-size: 17px; /* body-strong */
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        line-height: 1.24;
        letter-spacing: -0.374px;
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
        font-size: 17px; /* body */
        font-weight: 600;
        color: #30d158; /* Apple green for dark mode */
        margin-bottom: 0.75rem;
        letter-spacing: -0.374px;
    }

    [data-theme="light"] .product-card-price {
        color: var(--ink); /* Ink for light mode */
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

    /* Premium Dropdown & Input Styles */
    .custom-select-premium, .price-input-premium {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
        border-radius: 980px;
        padding: 0.6rem 1rem;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .custom-select-premium:focus, .price-input-premium:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.12);
        color: var(--text-main);
        outline: none;
    }

    [data-theme="light"] .custom-select-premium, [data-theme="light"] .price-input-premium {
        background: rgba(0, 0, 0, 0.03);
        color: #1d1d1f;
    }

    [data-theme="light"] .custom-select-premium:focus, [data-theme="light"] .price-input-premium:focus {
        background: rgba(0, 0, 0, 0.05);
        color: #1d1d1f;
    }

    /* Option elements styling */
    .custom-select-premium option {
        background: #1d1d1f;
        color: #f5f5f7;
    }

    [data-theme="light"] .custom-select-premium option {
        background: #ffffff;
        color: #1d1d1f;
    }

    /* Stock badge */
    .stock-badge {
        display: inline-flex;
        align-items: center;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 980px;
        letter-spacing: 0.1px;
    }
    .stock-success {
        background: rgba(48, 209, 88, 0.12);
        color: #30d158;
        border: 1px solid rgba(48, 209, 88, 0.25);
    }
    [data-theme="light"] .stock-success {
        background: rgba(52, 199, 89, 0.1);
        color: #1a8a3a;
        border: 1px solid rgba(52, 199, 89, 0.25);
    }
    .stock-warning {
        background: rgba(255, 159, 10, 0.12);
        color: #ff9f0a;
        border: 1px solid rgba(255, 159, 10, 0.25);
    }
    [data-theme="light"] .stock-warning {
        background: rgba(255, 149, 0, 0.1);
        color: #b86e00;
        border: 1px solid rgba(255, 149, 0, 0.25);
    }
    .stock-danger {
        background: rgba(255, 69, 58, 0.12);
        color: #ff453a;
        border: 1px solid rgba(255, 69, 58, 0.25);
    }
    [data-theme="light"] .stock-danger {
        background: rgba(255, 59, 48, 0.1);
        color: #c0392b;
        border: 1px solid rgba(255, 59, 48, 0.25);
    }
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
            <?php if (SessionHelper::isAdmin()): ?>
                <a href="<?php echo BASE_URL; ?>/Product/add" class="btn btn-premium">
                    <i class="fa-solid fa-plus me-2"></i>Thêm sản phẩm
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Filter Form Panel -->
<div class="glass-card mb-4 p-4">
    <form id="filterForm" method="GET" action="<?php echo BASE_URL; ?>/Product" class="row g-3 align-items-end">
        <!-- Search Keyword -->
        <div class="col-12 col-md-4">
            <label class="form-label text-muted small fw-bold text-uppercase mb-2"><i class="fa-solid fa-magnifying-glass me-1"></i>Từ khóa</label>
            <div class="search-box" style="max-width: 100%;">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" id="searchInput" name="search" class="form-control" placeholder="Tìm tên, mô tả..." 
                       value="<?php echo htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off">
            </div>
        </div>
        
        <!-- Category Filter -->
        <div class="col-6 col-md-2">
            <label class="form-label text-muted small fw-bold text-uppercase mb-2"><i class="fa-solid fa-tags me-1"></i>Danh mục</label>
            <select name="category_id" class="form-select custom-select-premium" onchange="submitFilterForm()">
                <option value="">Tất cả</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat->id; ?>" <?php echo (isset($selected_category_id) && $selected_category_id == $cat->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Sorting -->
        <div class="col-6 col-md-2">
            <label class="form-label text-muted small fw-bold text-uppercase mb-2"><i class="fa-solid fa-arrow-down-wide-short me-1"></i>Sắp xếp</label>
            <select name="sort_by" class="form-select custom-select-premium" onchange="submitFilterForm()">
                <option value="newest" <?php echo ($sort_by ?? 'newest') == 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                <option value="price_asc" <?php echo ($sort_by ?? '') == 'price_asc' ? 'selected' : ''; ?>>Giá tăng dần</option>
                <option value="price_desc" <?php echo ($sort_by ?? '') == 'price_desc' ? 'selected' : ''; ?>>Giá giảm dần</option>
                <option value="name_asc" <?php echo ($sort_by ?? '') == 'name_asc' ? 'selected' : ''; ?>>Tên A-Z</option>
                <option value="name_desc" <?php echo ($sort_by ?? '') == 'name_desc' ? 'selected' : ''; ?>>Tên Z-A</option>
            </select>
        </div>

        <!-- Price Range Filter -->
        <div class="col-12 col-md-4">
            <label class="form-label text-muted small fw-bold text-uppercase mb-2"><i class="fa-solid fa-money-bill-wave me-1"></i>Khoảng giá (VND)</label>
            <div class="d-flex align-items-center gap-2">
                <input type="number" id="minPriceInput" name="min_price" class="form-control price-input-premium" placeholder="Min" 
                       value="<?php echo isset($min_price) ? htmlspecialchars($min_price, ENT_QUOTES, 'UTF-8') : ''; ?>">
                <span class="text-muted">—</span>
                <input type="number" id="maxPriceInput" name="max_price" class="form-control price-input-premium" placeholder="Max" 
                       value="<?php echo isset($max_price) ? htmlspecialchars($max_price, ENT_QUOTES, 'UTF-8') : ''; ?>">
                <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-glass-secondary px-3" title="Xóa bộ lọc">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </div>
    </form>
</div>

<?php if (!empty($keyword) || !empty($selected_category_id) || !empty($min_price) || !empty($max_price)): ?>
    <div class="mb-4 d-flex align-items-center gap-2 flex-wrap">
        <span class="text-muted small">Đang lọc theo:</span>
        <?php if (!empty($keyword)): ?>
            <span class="badge-premium" style="font-size: 0.8rem;">Từ khóa: "<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"</span>
        <?php endif; ?>
        <?php if (!empty($selected_category_id)): ?>
            <?php 
            $selected_cat_name = 'Danh mục';
            foreach ($categories as $cat) {
                if ($cat->id == $selected_category_id) {
                    $selected_cat_name = $cat->name;
                    break;
                }
            }
            ?>
            <span class="badge-premium" style="font-size: 0.8rem;">Danh mục: <?php echo htmlspecialchars($selected_cat_name, ENT_QUOTES, 'UTF-8'); ?></span>
        <?php endif; ?>
        <?php if (!empty($min_price) || !empty($max_price)): ?>
            <span class="badge-premium" style="font-size: 0.8rem;">Giá: 
                <?php 
                if (!empty($min_price) && !empty($max_price)) {
                    echo number_format($min_price, 0, ',', '.') . 'đ - ' . number_format($max_price, 0, ',', '.') . 'đ';
                } elseif (!empty($min_price)) {
                    echo '>= ' . number_format($min_price, 0, ',', '.') . 'đ';
                } else {
                    echo '<= ' . number_format($max_price, 0, ',', '.') . 'đ';
                }
                ?>
            </span>
        <?php endif; ?>
        <span class="text-muted ms-md-auto small">(Tìm thấy <?php echo $totalProducts; ?> kết quả)</span>
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

                        <!-- Stock badge -->
                        <div class="mb-2">
                            <?php
                            $stock = (int)($product->stock ?? 0);
                            if ($stock <= 0) {
                                $stockClass = 'danger';
                                $stockLabel = 'Hết hàng';
                                $stockIcon = 'fa-ban';
                            } elseif ($stock <= 5) {
                                $stockClass = 'warning';
                                $stockLabel = 'Sắp hết (' . $stock . ')';
                                $stockIcon = 'fa-triangle-exclamation';
                            } else {
                                $stockClass = 'success';
                                $stockLabel = 'Còn ' . $stock;
                                $stockIcon = 'fa-check';
                            }
                            ?>
                            <span class="stock-badge stock-<?php echo $stockClass; ?>">
                                <i class="fa-solid <?php echo $stockIcon; ?> me-1"></i><?php echo $stockLabel; ?>
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="product-card-actions">
                            <button onclick="addToCartAjax(event, '<?php echo $product->id; ?>')" class="btn btn-premium btn-sm flex-grow-1" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-cart-plus me-1"></i>Thêm giỏ
                            </button>
                            <?php if (SessionHelper::isAdmin()): ?>
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
                $getParams = $_GET;
                unset($getParams['page']);
                $queryParams = !empty($getParams) ? '&' . http_build_query($getParams) : '';
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
            window.location.href = '<?php echo BASE_URL; ?>/Product/delete/' + id + '?csrf_token=<?php echo SessionHelper::getCSRFToken(); ?>';
        }
    })
}

// Dynamic Filter Functions
let filterTimeout = null;

function submitFilterForm() {
    document.getElementById('filterForm').submit();
}

function debouncedSubmitFilterForm() {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(() => {
        submitFilterForm();
    }, 600);
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');
    
    if (searchInput) searchInput.addEventListener('input', debouncedSubmitFilterForm);
    if (minPriceInput) minPriceInput.addEventListener('input', debouncedSubmitFilterForm);
    if (maxPriceInput) maxPriceInput.addEventListener('input', debouncedSubmitFilterForm);
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
