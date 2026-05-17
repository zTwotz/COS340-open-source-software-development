<?php include 'app/views/shares/header.php'; ?>

<style>
    .success-icon-wrapper {
        font-size: 5rem;
        color: #30d158; /* Apple green */
        animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
        margin-bottom: 1.5rem;
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<div class="row py-5">
    <div class="col-md-6 mx-auto text-center">
        <div class="glass-card py-5 px-4 shadow-lg">
            <div class="success-icon-wrapper">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            
            <h1 class="text-gradient fw-bold mb-3">Đặt Hàng Thành Công!</h1>
            
            <p class="text-white fs-5 mb-2">Cảm ơn bạn đã mua sắm tại NTECH STORE.</p>
            <p class="text-muted mb-4">Đơn hàng của bạn đã được tiếp nhận và xử lý thành công. Nhân viên của chúng tôi sẽ sớm liên hệ với bạn để xác nhận thông tin giao hàng.</p>
            
            <hr class="my-4" style="border-color: var(--glass-border);">
            
            <div class="d-flex gap-3 justify-content-center">
                <a href="<?php echo BASE_URL; ?>/Product" class="btn btn-premium px-5 py-2.5">
                    <i class="fa-solid fa-house me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
