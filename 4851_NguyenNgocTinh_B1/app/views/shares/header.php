<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Admin - Product Management</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --secondary-bg: #f3f4f6;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --body-bg: #f9fafb;
            --text-color: #1f2937;
            --card-bg: #ffffff;
            --navbar-bg: rgba(255, 255, 255, 0.8);
        }

        [data-bs-theme="dark"] {
            --body-bg: #0f172a;
            --text-color: #f1f5f9;
            --card-bg: #1e293b;
            --glass-bg: rgba(15, 23, 42, 0.8);
            --navbar-bg: rgba(15, 23, 42, 0.8);
            --secondary-bg: #334155;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
            padding-top: 100px;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Navbar Styling */
        .navbar {
            background: var(--navbar-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 15px 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-color) !important;
            transition: all 0.3s ease;
            margin: 0 10px;
            opacity: 0.8;
        }

        .nav-link:hover {
            color: #6366f1 !important;
            transform: translateY(-2px);
            opacity: 1;
        }

        /* Buttons Styling */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 10px 24px;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
            opacity: 0.9;
        }

        /* Hero Section */
        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        /* Dark Mode Toggle */
        .theme-toggle {
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            background: var(--secondary-bg);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            border: none;
            color: var(--text-color);
        }

        .theme-toggle:hover {
            transform: rotate(15deg);
            background: var(--primary-gradient);
            color: white;
        }

        /* Global UI Elements */
        .card, .form-container, .search-card, .cat-item, .details-container, .product-card {
            background-color: var(--card-bg) !important;
            color: var(--text-color);
        }

        .form-control, .form-select {
            background-color: var(--secondary-bg) !important;
            border-color: transparent !important;
            color: var(--text-color) !important;
        }

        .text-muted {
            color: #94a3b8 !important;
        }

        .user-badge {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Cart Badge */
        .cart-icon-wrapper {
            position: relative;
            margin-right: 15px;
        }

        #cart-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 50%;
            font-weight: 700;
            border: 2px solid var(--navbar-bg);
        }
    </style>
</head>
<body data-bs-theme="light">

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/">
            <i class="fa-solid fa-bolt me-2"></i>NTECH STORE
        </a>
        
        <div class="d-flex align-items-center order-lg-3 ms-3">
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Cart/index" class="cart-icon-wrapper nav-link p-0">
                <i class="fa-solid fa-cart-shopping fs-5"></i>
                <span id="cart-count">0</span>
            </a>

            <button class="theme-toggle me-3" id="themeToggle" title="Chuyển chế độ Sáng/Tối">
                <i class="fa-solid fa-moon"></i>
            </button>
            
            <?php if (isset($_SESSION['user'])): ?>
                <div class="dropdown">
                    <a class="user-badge text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-user me-1"></i> <?php echo $_SESSION['user']['name']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-4">
                        <li><a class="dropdown-item py-2 px-4 rounded-top-4" href="#" onclick="processLogout()"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Account/login" class="btn btn-primary px-4 py-2">Đăng nhập</a>
            <?php endif; ?>

            <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/">
                        <i class="fa-solid fa-house me-1"></i> Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index">
                        <i class="fa-solid fa-layer-group me-1"></i> Sản phẩm
                    </a>
                </li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/add">
                            <i class="fa-solid fa-plus-circle me-1"></i> Thêm mới
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

<script>
    // Theme Toggle logic
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    const icon = themeToggle.querySelector('i');

    const savedTheme = localStorage.getItem('theme') || 'light';
    body.setAttribute('data-bs-theme', savedTheme);
    updateIcon(savedTheme);

    themeToggle.addEventListener('click', () => {
        const currentTheme = body.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        body.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon(newTheme);
    });

    function updateIcon(theme) {
        if (theme === 'dark') {
            icon.classList.remove('fa-moon'); icon.classList.add('fa-sun');
        } else {
            icon.classList.remove('fa-sun'); icon.classList.add('fa-moon');
        }
    }

    // Cart Logic (LocalStorage)
    function getCart() {
        return JSON.parse(localStorage.getItem('cart')) || [];
    }

    function updateCartCount() {
        const cart = getCart();
        const total = cart.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('cart-count').innerText = total;
    }

    function addToCart(id, name, price, image) {
        let cart = getCart();
        const existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ id, name, price, image, quantity: 1 });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();

        Swal.fire({
            icon: 'success',
            title: 'Đã thêm vào giỏ!',
            text: name + ' đã sẵn sàng trong giỏ hàng.',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    function processLogout() {
        // Xóa giỏ hàng khi đăng xuất
        localStorage.removeItem('cart');
        // Sau đó chuyển hướng tới logic logout của server
        window.location.href = '/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Account/logout';
    }

    // Initial update
    updateCartCount();
</script>