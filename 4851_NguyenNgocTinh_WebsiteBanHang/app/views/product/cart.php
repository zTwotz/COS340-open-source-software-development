<?php include 'app/views/shares/header.php'; ?>

<style>
    .cart-table-wrapper {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: var(--glass-shadow);
    }

    .qty-input {
        width: 70px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: white;
        border-radius: 6px;
        padding: 0.25rem 0.5rem;
        text-align: center;
        outline: none;
        transition: border-color 0.15s ease;
    }

    .qty-input:focus {
        border-color: var(--accent-color);
    }

    .cart-total-box {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: var(--glass-shadow);
    }

    .cart-thumb {
        width: 60px;
        height: 60px;
        object-fit: contain;
        background: rgba(255, 255, 255, 0.02);
        padding: 4px;
        border-radius: 8px;
        border: 1px solid var(--glass-border);
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="text-gradient fw-bold mb-1"><i class="fa-solid fa-cart-shopping me-2 text-primary"></i>Giỏ hàng của bạn</h1>
        <p class="text-muted mb-0">Xem lại các sản phẩm bạn đã chọn trước khi thanh toán</p>
    </div>
</div>

<?php if (empty($_SESSION['cart'])): ?>
    <div class="glass-card text-center py-5">
        <div class="mb-4 text-muted">
            <i class="fa-solid fa-basket-shopping fs-1 text-indigo-400" style="opacity: 0.6;"></i>
        </div>
        <h3>Giỏ hàng đang trống!</h3>
        <p class="text-muted">Bạn chưa thêm bất kỳ sản phẩm nào vào giỏ hàng của mình.</p>
        <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-premium mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại mua sắm
        </a>
    </div>
<?php else: ?>
    <div class="row">
        <!-- Cart Items List -->
        <div class="col-lg-8">
            <form action="<?php echo BASE_URL; ?>/Product/updateCart" method="POST">
                <div class="cart-table-wrapper">
                    <table class="table table-premium mb-0">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Giá bán</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grand_total = 0;
                            foreach ($_SESSION['cart'] as $id => $item): 
                                $subtotal = $item['price'] * $item['quantity'];
                                $grand_total += $subtotal;
                            ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($item['image']) && file_exists($item['image'])): ?>
                                            <img src="<?php echo BASE_URL . '/' . $item['image']; ?>" class="cart-thumb" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        <?php else: ?>
                                            <div class="d-flex justify-content-center align-items-center bg-dark rounded" style="width:60px; height:60px; border: 1px solid var(--glass-border);">
                                                <i class="fa-regular fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-white"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </td>
                                    <td>
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                                    </td>
                                    <td>
                                        <input type="number" name="quantities[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="qty-input">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</div>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/Product/removeFromCart/<?php echo $id; ?>" class="btn btn-sm btn-outline-danger border-0">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-glass-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                    <div>
                        <button type="submit" class="btn btn-glass-secondary me-2">
                            <i class="fa-solid fa-rotate me-2"></i>Cập nhật giỏ hàng
                        </button>
                        <a href="<?php echo BASE_URL; ?>/Product/clearCart" class="btn btn-premium-danger">
                            <i class="fa-solid fa-trash-can me-2"></i>Xóa toàn bộ
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Checkout Card -->
        <div class="col-lg-4">
            <div class="cart-total-box">
                <h4 class="fw-bold text-white mb-4"><i class="fa-solid fa-file-invoice-dollar me-2 text-primary"></i>Tổng đơn hàng</h4>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Tạm tính:</span>
                    <span class="text-white fw-bold"><?php echo number_format($grand_total, 0, ',', '.'); ?> VND</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Phí giao hàng:</span>
                    <span class="text-success fw-bold">Miễn phí</span>
                </div>
                
                <hr style="border-color: var(--glass-border);">
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-5 fw-bold text-white">Tổng cộng:</span>
                    <span class="fs-4 fw-bold text-success"><?php echo number_format($grand_total, 0, ',', '.'); ?> VND</span>
                </div>

                <a href="<?php echo BASE_URL; ?>/Product/checkout" class="btn btn-premium w-100 py-3 fs-5 text-decoration-none d-block text-center">
                    <i class="fa-solid fa-credit-card me-2"></i>Tiến hành thanh toán
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
function checkoutMock() {
    Swal.fire({
        title: 'Đặt hàng thành công!',
        text: 'Cảm ơn bạn đã mua sắm tại NTECH STORE. Đơn hàng của bạn đang được xử lý!',
        icon: 'success',
        background: '#1d1d1f',
        color: '#f5f5f7',
        confirmButtonColor: '#0071e3'
    }).then(() => {
        window.location.href = '<?php echo BASE_URL; ?>/Product/clearCart';
    });
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
