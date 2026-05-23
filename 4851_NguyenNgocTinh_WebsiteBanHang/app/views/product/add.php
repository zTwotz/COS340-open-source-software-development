<?php include 'app/views/shares/header.php'; ?>

<style>
    .form-control-glass {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-main);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control-glass:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--accent-color);
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.15);
        color: var(--text-main);
    }

    .form-label {
        font-weight: 500;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-card {
        animation: fadeInUp 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--accent-color) 0%, #147ce5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        flex-shrink: 0;
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.85rem;
        pointer-events: none;
        z-index: 2;
    }

    .input-icon-wrapper textarea ~ .input-icon {
        top: 1.15rem;
        transform: none;
    }

    .input-icon-wrapper .form-control-glass {
        padding-left: 2.8rem;
    }

    .char-counter {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-align: right;
        margin-top: 0.25rem;
    }
</style>

<!-- Breadcrumb -->
<div class="row mb-3">
    <div class="col-md-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/Product" class="text-muted text-decoration-none">Sản phẩm</a></li>
                <li class="breadcrumb-item active" style="color: var(--text-main);" aria-current="page">Thêm sản phẩm mới</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="glass-card form-card">
            <!-- Header -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="form-icon">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <h2 class="text-gradient fw-bold mb-0">Thêm sản phẩm mới</h2>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Nhập thông tin sản phẩm</p>
                </div>
            </div>

            <form id="add-product-form" method="POST" action="<?php echo BASE_URL; ?>/Product/save" enctype="multipart/form-data">
                <?php echo '<input type="hidden" name="csrf_token" value="' . SessionHelper::getCSRFToken() . '">'; ?>

                <div class="row g-4">
                    <!-- Tên sản phẩm -->
                    <div class="col-12">
                        <label for="name" class="form-label"><i class="fa-solid fa-tag me-1"></i>Tên sản phẩm</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-box input-icon"></i>
                            <input type="text" id="name" name="name" class="form-control form-control-glass" placeholder="Ví dụ: iPhone 16 Pro Max 256GB..." required>
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="col-12">
                        <label for="description" class="form-label"><i class="fa-solid fa-align-left me-1"></i>Mô tả sản phẩm</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-pen-fancy input-icon"></i>
                            <textarea id="description" name="description" class="form-control form-control-glass" rows="4" placeholder="Mô tả chi tiết về sản phẩm, tính năng nổi bật..." required></textarea>
                        </div>
                        <div class="char-counter"><span id="desc-count">0</span> ký tự</div>
                    </div>

                    <!-- Giá bán -->
                    <div class="col-sm-6">
                        <label for="price" class="form-label"><i class="fa-solid fa-coins me-1"></i>Giá bán (VND)</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-dong-sign input-icon"></i>
                            <input type="number" id="price" name="price" class="form-control form-control-glass" step="1000" placeholder="0" required>
                        </div>
                        <div class="error-msg text-danger mt-1 fw-medium" id="price-error" style="font-size: 0.8rem; display: none;">
                            <i class="fa-solid fa-circle-exclamation me-1"></i>Không được nhập số âm!
                        </div>
                    </div>

                    <!-- Số lượng tồn kho -->
                    <div class="col-sm-6">
                        <label for="stock" class="form-label"><i class="fa-solid fa-cubes me-1"></i>Số lượng tồn kho</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-hashtag input-icon"></i>
                            <input type="number" id="stock" name="stock" class="form-control form-control-glass" step="1" placeholder="0" required>
                        </div>
                        <div class="error-msg text-danger mt-1 fw-medium" id="stock-error" style="font-size: 0.8rem; display: none;">
                            <i class="fa-solid fa-circle-exclamation me-1"></i>Không được nhập số âm!
                        </div>
                    </div>

                    <!-- Ảnh sản phẩm -->
                    <div class="col-sm-6">
                        <label for="image" class="form-label"><i class="fa-solid fa-image me-1"></i>Ảnh sản phẩm</label>
                        <input type="file" id="image" name="image" accept="image/*" class="form-control form-control-glass">
                    </div>

                    <!-- Danh mục -->
                    <div class="col-sm-6">
                        <label for="category_id" class="form-label"><i class="fa-solid fa-folder me-1"></i>Danh mục</label>
                        <select id="category_id" name="category_id" class="form-control form-control-glass" required>
                            <option value="" disabled selected>-- Chọn danh mục --</option>
                            <!-- Loaded via API -->
                        </select>
                    </div>
                </div>

                <hr class="my-4" style="border-color: var(--glass-border);">

                <!-- Actions -->
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-glass-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-premium px-4" id="submit-btn">
                        <i class="fa-solid fa-plus me-2"></i>Thêm sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Character counter for description
    const desc = document.getElementById('description');
    const countSpan = document.getElementById('desc-count');
    if (desc && countSpan) {
        desc.addEventListener('input', function() {
            countSpan.textContent = this.value.length;
        });
    }

    // Live validation for negative numbers
    const priceInput = document.getElementById('price');
    const stockInput = document.getElementById('stock');
    const submitBtn = document.getElementById('submit-btn');

    function validateInputs() {
        let isPriceInvalid = false;
        let isStockInvalid = false;

        const priceVal = parseFloat(priceInput.value);
        if (!isNaN(priceVal) && priceVal < 0) {
            document.getElementById('price-error').style.display = 'block';
            priceInput.style.borderColor = '#ff453a';
            isPriceInvalid = true;
        } else {
            document.getElementById('price-error').style.display = 'none';
            priceInput.style.borderColor = '';
        }

        const stockVal = parseInt(stockInput.value);
        if (!isNaN(stockVal) && stockVal < 0) {
            document.getElementById('stock-error').style.display = 'block';
            stockInput.style.borderColor = '#ff453a';
            isStockInvalid = true;
        } else {
            document.getElementById('stock-error').style.display = 'none';
            stockInput.style.borderColor = '';
        }

        if (isPriceInvalid || isStockInvalid) {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }

    if (priceInput && stockInput) {
        priceInput.addEventListener('input', validateInputs);
        stockInput.addEventListener('input', validateInputs);
    }

    const currentTheme = localStorage.getItem('theme') || 'dark';

    // Load categories from API
    fetch('<?php echo BASE_URL; ?>/api/category')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi tải danh mục',
                text: 'Không thể tải danh sách danh mục từ API.',
                background: currentTheme === 'light' ? '#ffffff' : '#1d1d1f',
                color: currentTheme === 'light' ? '#1d1d1f' : '#f5f5f7',
                confirmButtonColor: '#ff453a'
            });
        });
});
</script>
