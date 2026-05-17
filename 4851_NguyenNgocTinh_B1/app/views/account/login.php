<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - NTECH STORE</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top right, #6366f1, transparent),
                        radial-gradient(circle at bottom left, #a855f7, transparent);
            background-color: #0f172a;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .login-logo {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            text-align: center;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }

        .demo-info {
            background: #f8fafc;
            border-radius: 15px;
            padding: 20px;
            margin-top: 25px;
        }

        .btn-quick-login {
            border: 1px solid #e2e8f0;
            background: white;
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #4b5563;
            transition: all 0.2s;
            flex: 1;
        }

        .btn-quick-login:hover {
            border-color: #6366f1;
            color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }
    </style>
</head>
<body>

<div class="login-card">
    <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/" class="text-decoration-none">
        <div class="login-logo"><i class="fa-solid fa-bolt me-2"></i>NTECH STORE</div>
    </a>
    <p class="text-center text-muted mb-4">Đăng nhập để tiếp tục quản lý kho hàng</p>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger py-2 rounded-3 small mb-4">
            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Account/login" onsubmit="clearCart()">
        <div class="mb-1">
            <label class="form-label small fw-bold text-muted">EMAIL</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="admin@gmail.com" required>
        </div>
        <div class="mb-1">
            <label class="form-label small fw-bold text-muted">MẬT KHẨU</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••" required>
        </div>
        <button type="submit" class="btn btn-login">ĐĂNG NHẬP NGAY</button>
    </form>

    <div class="text-center mt-4">
        <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/" class="text-muted text-decoration-none small fw-bold">
            <i class="fa-solid fa-arrow-left me-1"></i> Quay lại trang chủ
        </a>
    </div>

    <div class="demo-info">
        <div class="fw-bold mb-3 text-dark small text-center text-uppercase" style="letter-spacing: 1px;">Chọn vai trò đăng nhập</div>
        <div class="d-flex gap-2">
            <button class="btn-quick-login" onclick="quickLogin('admin@gmail.com', '123')">
                <i class="fa-solid fa-user-shield me-1"></i> Admin
            </button>
            <button class="btn-quick-login" onclick="quickLogin('user@gmail.com', '123')">
                <i class="fa-solid fa-user me-1"></i> User
            </button>
        </div>
    </div>
</div>

<script>
    function clearCart() {
        localStorage.removeItem('cart');
    }

    function quickLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        
        const btn = document.querySelector('.btn-login');
        btn.classList.add('animate-pulse');
        setTimeout(() => btn.classList.remove('animate-pulse'), 1000);
    }
</script>

</body>
</html>
