<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NTECH STORE - Quản Lý Bán Hàng</title>
    <meta name="description" content="NTECH STORE - Cửa hàng công nghệ hàng đầu. Sản phẩm chất lượng, giá tốt nhất.">
    <!-- Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Immediately load preferred theme before rendering to avoid theme flash
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    
    <style>
        :root {
            /* Apple Design System Variables */
            --pure-black: #000000;
            --white: #ffffff;
            --light-gray: #f5f5f7;
            --black: #1d1d1f;
            --apple-blue: #0071e3;
            --link-blue: #0066cc;
            --link-blue-dark: #2997ff;
            --gray-80: rgba(0, 0, 0, 0.8);
            --gray-48: rgba(0, 0, 0, 0.48);
            
            --bg-gradient: #000000; /* Pure black */
            --glass-bg: #1d1d1f; /* Apple dark surface */
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: rgba(0, 0, 0, 0.4) 0px 8px 30px;
            --accent-color: #0071e3; /* Apple Blue */
            --accent-hover: #147ce5;
            --text-main: #f5f5f7;
            --text-muted: rgba(255, 255, 255, 0.6);
            --card-hover-bg: #272729; /* Elevated dark card bg */
            
            --font-display: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Helvetica Neue', sans-serif;
            --font-text: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Text', 'Helvetica Neue', sans-serif;
            --text-gradient: linear-gradient(180deg, #ffffff 0%, #a1a1a6 100%);
            
            /* Navbar variables */
            --nav-bg: rgba(0, 0, 0, 0.8);
            --nav-border: rgba(255, 255, 255, 0.08);
            --nav-link: rgba(255, 255, 255, 0.8);
            --nav-link-hover: #ffffff;
            --nav-brand: #ffffff;
            
            /* Footer variables */
            --footer-bg: #000000;
            --footer-border: rgba(255, 255, 255, 0.08);
            --footer-text: rgba(255, 255, 255, 0.48);
        }

        /* Light Theme variables override */
        [data-theme="light"] {
            --bg-gradient: #f5f5f7; /* Apple light gray background */
            --glass-bg: #ffffff; /* Pure white card surface */
            --glass-border: rgba(0, 0, 0, 0.08);
            --glass-shadow: rgba(0, 0, 0, 0.04) 0px 8px 30px;
            --text-main: #1d1d1f; /* Apple dark charcoal text */
            --text-muted: rgba(29, 29, 31, 0.65);
            --card-hover-bg: #f5f5f7; /* Light card hover bg */
            --text-gradient: linear-gradient(180deg, #1d1d1f 0%, #6e6e73 100%);
            
            /* Navbar variables in Light mode */
            --nav-bg: rgba(255, 255, 255, 0.8);
            --nav-border: rgba(0, 0, 0, 0.08);
            --nav-link: rgba(0, 0, 0, 0.65);
            --nav-link-hover: #000000;
            --nav-brand: #000000;
            
            /* Footer variables in Light mode */
            --footer-bg: #f5f5f7;
            --footer-border: rgba(0, 0, 0, 0.08);
            --footer-text: rgba(0, 0, 0, 0.48);
        }

        /* Smooth visual transitions */
        body, .glass-card, .navbar, .footer, tr, td, .form-control-glass, a, button, span, h1, h2, h3, h4, h5, h6, .input-group-text, .preview-container {
            transition: background-color 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), 
                        color 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), 
                        border-color 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), 
                        box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: var(--font-text);
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            letter-spacing: -0.374px;
            -webkit-font-smoothing: antialiased;
        }

        .navbar {
            background: var(--nav-bg) !important;
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid var(--nav-border);
            height: 48px;
            padding: 0 !important;
        }

        .navbar-brand {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 1.15rem;
            letter-spacing: -0.28px;
            color: var(--nav-brand) !important;
            display: flex;
            align-items: center;
        }

        .nav-link {
            font-size: 12px;
            font-weight: 400;
            color: var(--nav-link) !important;
            transition: color 0.15s ease;
            padding: 0.5rem 1rem !important;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--nav-link-hover) !important;
        }

        .nav-link.active::after {
            display: none;
        }

        .main-container {
            flex: 1;
            padding-top: 3.5rem;
            padding-bottom: 5rem;
        }

        .glass-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            box-shadow: var(--glass-shadow);
            padding: 2rem;
            transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1), background-color 0.2s ease, box-shadow 0.3s ease;
        }

        .btn-premium {
            background: var(--accent-color);
            border: none;
            color: white !important;
            font-weight: 400;
            padding: 8px 22px;
            border-radius: 980px; /* Signature Apple Pill */
            transition: opacity 0.15s ease, transform 0.1s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-premium:hover {
            opacity: 0.88;
            color: white !important;
        }

        .btn-premium:active {
            transform: scale(0.98);
        }

        .btn-glass-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-main);
            font-weight: 400;
            padding: 8px 22px;
            border-radius: 980px;
            transition: background 0.15s ease, transform 0.1s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        [data-theme="light"] .btn-glass-secondary {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .btn-glass-secondary:hover {
            background: rgba(255, 255, 255, 0.18);
            color: var(--text-main);
        }

        [data-theme="light"] .btn-glass-secondary:hover {
            background: rgba(0, 0, 0, 0.1);
        }

        .btn-glass-secondary:active {
            transform: scale(0.98);
        }

        .btn-premium-danger {
            background: #ff453a; /* Apple system red */
            border: none;
            color: white;
            font-weight: 400;
            padding: 8px 22px;
            border-radius: 980px;
            transition: opacity 0.15s ease, transform 0.1s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-premium-danger:hover {
            opacity: 0.88;
            color: white;
        }

        .btn-premium-danger:active {
            transform: scale(0.98);
        }

        .btn-premium-warning {
            background: #ff9f0a; /* Apple system orange */
            border: none;
            color: white;
            font-weight: 400;
            padding: 8px 22px;
            border-radius: 980px;
            transition: opacity 0.15s ease, transform 0.1s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-premium-warning:hover {
            opacity: 0.88;
            color: white;
        }

        .btn-premium-warning:active {
            transform: scale(0.98);
        }

        .text-gradient {
            font-family: var(--font-display);
            background: var(--text-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.28px;
        }

        .table-premium {
            --bs-table-bg: transparent !important;
            --bs-table-color: var(--text-main) !important;
            --bs-table-border-color: var(--glass-border) !important;
            --bs-table-striped-bg: rgba(255, 255, 255, 0.02) !important;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.04) !important;
            color: var(--text-main) !important;
        }

        [data-theme="light"] .table-premium {
            --bs-table-striped-bg: rgba(0, 0, 0, 0.01) !important;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.02) !important;
        }

        .table-premium th {
            font-weight: 500;
            color: var(--text-muted);
            border-bottom: 1px solid var(--glass-border) !important;
            padding: 1rem;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-premium td {
            vertical-align: middle;
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem;
            color: var(--text-main);
            font-size: 15px;
            opacity: 0.9;
        }

        .table-premium tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        [data-theme="light"] .table-premium tr:hover {
            background: rgba(0, 0, 0, 0.01);
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .footer {
            background: var(--footer-bg);
            border-top: 1px solid var(--footer-border);
            padding: 2rem 0;
            font-size: 12px;
            color: var(--footer-text);
            margin-top: auto;
            letter-spacing: -0.12px;
        }
        
        .footer a {
            color: var(--link-blue-dark);
            text-decoration: none;
        }

        [data-theme="light"] .footer a {
            color: var(--link-blue);
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .badge-premium {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--link-blue-dark);
            padding: 0.3em 0.8em;
            border-radius: 980px;
            font-weight: 500;
            font-size: 0.8rem;
            letter-spacing: -0.2px;
        }

        [data-theme="light"] .badge-premium {
            background: rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.06);
            color: var(--link-blue);
        }

        /* Cart counter badge */
        .cart-badge {
            position: absolute;
            top: -4px;
            right: -6px;
            padding: 2px 6px;
            border-radius: 50%;
            background: #ff453a;
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
        }

        /* Light Mode Specific Form Control Overrides */
        [data-theme="light"] .form-control-glass {
            background: rgba(0, 0, 0, 0.03) !important;
            color: #1d1d1f !important;
        }

        [data-theme="light"] .form-control-glass:focus {
            background: rgba(0, 0, 0, 0.05) !important;
            color: #1d1d1f !important;
        }

        [data-theme="light"] .input-group-text {
            background: rgba(0, 0, 0, 0.02) !important;
            border-color: var(--glass-border) !important;
            color: rgba(29, 29, 31, 0.5) !important;
        }

        [data-theme="light"] .preview-placeholder {
            color: rgba(29, 29, 31, 0.5) !important;
        }

        [data-theme="light"] .preview-container {
            background: rgba(0, 0, 0, 0.01) !important;
        }
        
        [data-theme="light"] .no-image-placeholder {
            background: rgba(0, 0, 0, 0.03) !important;
            color: rgba(29, 29, 31, 0.4) !important;
        }
        
        [data-theme="light"] .product-card {
            background: #ffffff !important;
            box-shadow: rgba(0, 0, 0, 0.03) 0px 4px 20px !important;
        }
        
        [data-theme="light"] .product-card:hover {
            box-shadow: rgba(0, 0, 0, 0.08) 0px 8px 30px !important;
            background: #ffffff !important;
        }

        [data-theme="light"] .cart-total-box {
            background: rgba(0, 0, 0, 0.02) !important;
        }

        [data-theme="light"] .order-summary-card {
            background: rgba(0, 0, 0, 0.02) !important;
        }

        /* User badge in nav */
        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 980px;
            padding: 4px 12px 4px 8px;
            font-size: 12px;
            color: var(--text-main);
        }

        .user-badge .user-avatar {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
            color: white;
        }

        [data-theme="light"] .user-badge {
            background: rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>

    <!-- Dynamic base path detection -->
    <?php
    $current_uri = $_SERVER['REQUEST_URI'] ?? '';
    function is_active($route) {
        global $current_uri;
        if (!empty($route) && is_string($route) && is_string($current_uri) && strpos($current_uri, $route) !== false) {
            return 'active';
        }
        return '';
    }
    
    // Count items in cart
    $cart_count = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cart_count += $item['quantity'];
        }
    }

    // Check login state from session
    $isLoggedIn = SessionHelper::isLoggedIn();
    $currentUsername = $_SESSION['username'] ?? '';
    $currentFullname = $_SESSION['user_fullname'] ?? $currentUsername;
    $currentRole = $_SESSION['user_role'] ?? 'user';
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/Product">
                <i class="fa-solid fa-laptop-code me-2 text-primary"></i>NTECH STORE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo is_active('/Product') && !is_active('/Product/add') && !is_active('/Product/cart') && !is_active('/Product/checkout') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/Product">
                            <i class="fa-solid fa-boxes-stacked me-1"></i>Sản phẩm
                        </a>
                    </li>
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active('/Product/add') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/Product/add">
                                <i class="fa-solid fa-plus me-1"></i>Thêm sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active('/Category') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/Category/list">
                                <i class="fa-solid fa-tags me-1"></i>Danh mục
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <?php if ($isLoggedIn): ?>
                        <div class="user-badge">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($currentUsername, 0, 1)); ?>
                            </div>
                            <span><?php echo htmlspecialchars($currentFullname, ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php if ($currentRole === 'admin'): ?>
                                <span class="badge bg-warning text-dark" style="font-size: 9px; padding: 2px 6px; border-radius: 4px;">Admin</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo BASE_URL; ?>/account/logout" class="btn btn-outline-light border-0 nav-link p-2" title="Đăng xuất">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/account/login" class="btn btn-premium btn-sm" style="font-size: 12px;">
                            <i class="fa-solid fa-user me-1"></i>Đăng nhập
                        </a>
                    <?php endif; ?>

                    <button id="theme-toggle" class="btn btn-outline-light border-0 text-muted nav-link p-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" aria-label="Toggle theme" title="Chuyển chế độ sáng/tối">
                        <i class="fa-solid fa-moon fs-5" id="theme-icon"></i>
                    </button>
                    <a href="<?php echo BASE_URL; ?>/Product/cart" class="btn btn-outline-light border-0 position-relative text-muted nav-link <?php echo is_active('/Product/cart') ? 'active' : ''; ?> p-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-cart-shopping fs-5"></i>
                        <?php if ($cart_count > 0): ?>
                            <span class="cart-badge" style="top: -2px; right: -2px;"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container main-container">
        
        <!-- SweetAlert2 flash notifications -->
        <?php if (isset($_SESSION['success_msg'])): ?>
            <script>
                (function() {
                    const currentTheme = localStorage.getItem('theme') || 'dark';
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: '<?php echo htmlspecialchars($_SESSION['success_msg'], ENT_QUOTES, 'UTF-8'); ?>',
                        background: currentTheme === 'light' ? '#ffffff' : '#1d1d1f',
                        color: currentTheme === 'light' ? '#1d1d1f' : '#f5f5f7',
                        confirmButtonColor: '#0071e3',
                        timer: 3000
                    });
                })();
            </script>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_msg'])): ?>
            <script>
                (function() {
                    const currentTheme = localStorage.getItem('theme') || 'dark';
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: '<?php echo htmlspecialchars($_SESSION['error_msg'], ENT_QUOTES, 'UTF-8'); ?>',
                        background: currentTheme === 'light' ? '#ffffff' : '#1d1d1f',
                        color: currentTheme === 'light' ? '#1d1d1f' : '#f5f5f7',
                        confirmButtonColor: '#ff453a',
                        timer: 4000
                    });
                })();
            </script>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>
