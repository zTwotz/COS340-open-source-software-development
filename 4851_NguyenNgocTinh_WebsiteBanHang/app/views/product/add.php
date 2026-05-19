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
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Nhập thông tin sản phẩm qua API</p>
                </div>
            </div>

            <form id="add-product-form">
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

                    <!-- Giá + Danh mục (2 cột) -->
                    <div class="col-sm-6">
                        <label for="price" class="form-label"><i class="fa-solid fa-coins me-1"></i>Giá bán (VND)</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-dong-sign input-icon"></i>
                            <input type="number" id="price" name="price" class="form-control form-control-glass" step="1000" min="0" placeholder="0" required>
                        </div>
                    </div>

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
                    <a href="<?= BASE_URL ?>/Product" class="btn btn-glass-secondary">
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
// Character counter for description
document.getElementById('description').addEventListener('input', function() {
    document.getElementById('desc-count').textContent = this.value.length;
});

document.addEventListener("DOMContentLoaded", function() {
    const currentTheme = localStorage.getItem('theme') || 'dark';

    // Load categories from API
    fetch('<?= BASE_URL ?>/api/category')
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

    // Form submission
    document.getElementById('add-product-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Đang xử lý...';

        const formData = new FormData(this);
        const jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        fetch('<?= BASE_URL ?>/api/product', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product created successfully') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Sản phẩm đã được thêm vào hệ thống.',
                    background: currentTheme === 'light' ? '#ffffff' : '#1d1d1f',
                    color: currentTheme === 'light' ? '#1d1d1f' : '#f5f5f7',
                    confirmButtonColor: '#0071e3',
                    timer: 2000
                }).then(() => {
                    location.href = '<?= BASE_URL ?>/Product';
                });
            } else {
                let errorMsg = 'Vui lòng kiểm tra lại thông tin.';
                if (data.errors) {
                    errorMsg = Object.values(data.errors).join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Thêm sản phẩm thất bại',
                    text: errorMsg,
                    background: currentTheme === 'light' ? '#ffffff' : '#1d1d1f',
                    color: currentTheme === 'light' ? '#1d1d1f' : '#f5f5f7',
                    confirmButtonColor: '#ff453a'
                });
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-plus me-2"></i>Thêm sản phẩm';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi kết nối',
                text: 'Không thể kết nối tới máy chủ. Vui lòng thử lại.',
                background: currentTheme === 'light' ? '#ffffff' : '#1d1d1f',
                color: currentTheme === 'light' ? '#1d1d1f' : '#f5f5f7',
                confirmButtonColor: '#ff453a'
            });
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-plus me-2"></i>Thêm sản phẩm';
        });
    });
});
</script>
