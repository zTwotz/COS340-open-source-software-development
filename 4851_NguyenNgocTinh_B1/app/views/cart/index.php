<?php include 'app/views/shares/header.php'; ?>

<style>
    .cart-container {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: var(--card-shadow);
        margin-top: 20px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.3s;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-img-box {
        width: 100px;
        height: 100px;
        border-radius: 15px;
        background: #f8fafc;
        overflow: hidden;
        margin-right: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .cart-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .qty-btn:hover {
        background: #f3f4f6;
        border-color: #6366f1;
        color: #6366f1;
    }

    .summary-card {
        background: #f8fafc;
        border-radius: 20px;
        padding: 30px;
        position: sticky;
        top: 120px;
    }

    .btn-checkout {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 15px;
        font-weight: 700;
        width: 100%;
        margin-top: 20px;
        transition: all 0.3s;
    }

    .btn-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.4);
    }
</style>

<div class="page-header">
    <h1>Giỏ hàng của bạn</h1>
    <p class="text-muted">Xem lại các lựa chọn và hoàn tất mua sắm</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="cart-container" id="cart-items-container">
            <!-- Items will be loaded here via JS -->
            <div class="text-center py-5">
                <i class="fa-solid fa-cart-shopping fa-3x text-muted mb-3"></i>
                <p>Giỏ hàng đang trống...</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="summary-card">
            <h4 class="fw-bold mb-4">Tổng quan đơn hàng</h4>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Tạm tính:</span>
                <span id="subtotal" class="fw-bold">0đ</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Phí vận chuyển:</span>
                <span class="text-success fw-bold">Miễn phí</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-4">
                <span class="fs-5 fw-bold">Tổng cộng:</span>
                <span id="total" class="fs-5 fw-bold text-primary">0đ</span>
            </div>
            
            <button class="btn-checkout" onclick="checkout()">
                TIẾN HÀNH THANH TOÁN
            </button>
            
            <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="btn btn-light w-100 mt-3 border-0 py-3 fw-bold rounded-4">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
</div>

<script>
    function renderCart() {
        const cart = getCart();
        const container = document.getElementById('cart-items-container');
        
        if (cart.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="fa-solid fa-cart-shopping fa-3x text-muted mb-3"></i>
                    <h4>Giỏ hàng của bạn đang trống</h4>
                    <p class="text-muted">Hãy quay lại cửa hàng để chọn sản phẩm nhé!</p>
                    <a href="/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index" class="btn btn-primary mt-3">Đến cửa hàng</a>
                </div>
            `;
            updateSummary(0);
            return;
        }

        let html = '';
        let total = 0;

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            html += `
                <div class="cart-item">
                    <div class="cart-img-box">
                        <img src="${item.image}" class="cart-img" alt="${item.name}">
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1">${item.name}</h5>
                        <div class="text-primary fw-bold">${new Intl.NumberFormat('vi-VN').format(item.price)}đ</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2 border rounded-3 p-1">
                            <button class="qty-btn" onclick="updateQty(${item.id}, -1)"><i class="fa-solid fa-minus"></i></button>
                            <span class="px-2 fw-bold" style="min-width: 30px; text-align: center;">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQty(${item.id}, 1)"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <div class="fw-bold text-end" style="min-width: 120px;">
                            ${new Intl.NumberFormat('vi-VN').format(itemTotal)}đ
                        </div>
                        <button class="btn text-danger ms-2" onclick="removeItem(${item.id})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        updateSummary(total);
    }

    function updateQty(id, change) {
        let cart = getCart();
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity += change;
            if (item.quantity < 1) item.quantity = 1;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateCartCount();
        }
    }

    function removeItem(id) {
        Swal.fire({
            title: 'Xóa sản phẩm?',
            text: "Bạn muốn bỏ sản phẩm này khỏi giỏ hàng?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Đúng, xóa nó!',
            cancelButtonText: 'Không'
        }).then((result) => {
            if (result.isConfirmed) {
                let cart = getCart();
                cart = cart.filter(i => i.id !== id);
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
                updateCartCount();
            }
        })
    }

    function updateSummary(total) {
        const formatted = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
        document.getElementById('subtotal').innerText = formatted;
        document.getElementById('total').innerText = formatted;
    }

    function checkout() {
        Swal.fire({
            icon: 'success',
            title: 'Đặt hàng thành công!',
            text: 'Cảm ơn bạn đã mua sắm tại NTECH STORE.',
            confirmButtonText: 'Về trang chủ'
        }).then(() => {
            localStorage.removeItem('cart');
            window.location.href = '/4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/';
        });
    }

    // Initial render
    renderCart();
</script>

<?php include 'app/views/shares/footer.php'; ?>
