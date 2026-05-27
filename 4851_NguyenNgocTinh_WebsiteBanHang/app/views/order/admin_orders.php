<?php include 'app/views/shares/header.php'; ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h1 class="text-gradient fw-bold mb-1"><i class="fa-solid fa-receipt me-2 text-primary"></i>Quản lý đơn hàng</h1>
        <p class="text-muted mb-0">Quản lý và cập nhật trạng thái đơn hàng của tất cả khách hàng</p>
    </div>
</div>

<div class="glass-card">
    <?php if (empty($orders)): ?>
        <div class="text-center py-5">
            <div class="mb-3 text-muted">
                <i class="fa-solid fa-inbox fs-1"></i>
            </div>
            <h5>Không có đơn hàng nào</h5>
            <p class="text-muted mb-0">Hệ thống chưa ghi nhận đơn hàng nào.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-premium mb-0">
                <thead>
                    <tr>
                        <th style="width: 8%;">Mã ĐH</th>
                        <th style="width: 20%;">Khách hàng</th>
                        <th style="width: 12%;">Số điện thoại</th>
                        <th style="width: 15%;">Tổng tiền</th>
                        <th style="width: 15%;">Ngày đặt</th>
                        <th style="width: 18%;">Trạng thái</th>
                        <th style="width: 12%;" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <a href="<?php echo BASE_URL; ?>/Order/show/<?php echo $order->id; ?>" class="fw-semibold text-decoration-none" style="color: var(--primary);">
                                    #OD-<?php echo $order->id; ?>
                                </a>
                            </td>
                            <td>
                                <div>
                                    <strong style="color: var(--text-main);"><?php echo htmlspecialchars($order->name, ENT_QUOTES, 'UTF-8'); ?></strong>
                                </div>
                                <small class="text-muted">
                                    <i class="fa-regular fa-user me-1"></i><?php echo htmlspecialchars($order->username ?? 'Khách vãng lai', ENT_QUOTES, 'UTF-8'); ?>
                                </small>
                            </td>
                            <td><span class="text-muted"><?php echo htmlspecialchars($order->phone, ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td>
                                <strong style="color: var(--primary);"><?php echo number_format($order->total_amount, 0, ',', '.'); ?> VND</strong>
                            </td>
                            <td>
                                <span class="text-muted" style="font-size: 14px;">
                                    <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?>
                                </span>
                            </td>
                            <td>
                                <form action="<?php echo BASE_URL; ?>/Order/updateStatus" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo SessionHelper::getCSRFToken(); ?>">
                                    <select name="status" class="form-select form-select-sm status-select" onchange="this.form.submit()" style="border-radius: 8px; font-size: 13px; font-weight: 500; padding: 4px 10px; width: auto; display: inline-block;">
                                        <option value="Chờ xác nhận" <?php echo $order->status === 'Chờ xác nhận' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                        <option value="Đang chuẩn bị hàng" <?php echo $order->status === 'Đang chuẩn bị hàng' ? 'selected' : ''; ?>>Đang chuẩn bị hàng</option>
                                        <option value="Đang giao hàng" <?php echo $order->status === 'Đang giao hàng' ? 'selected' : ''; ?>>Đang giao hàng</option>
                                        <option value="Đã giao hàng" <?php echo $order->status === 'Đã giao hàng' ? 'selected' : ''; ?>>Đã giao hàng</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo BASE_URL; ?>/Order/show/<?php echo $order->id; ?>" class="btn btn-sm btn-glass-secondary py-1 px-3" title="Xem chi tiết">
                                    <i class="fa-solid fa-eye me-1"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
    .status-select {
        background-color: var(--canvas-parchment);
        color: var(--text-main);
        border: 1px solid var(--glass-border);
    }
    .status-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
    }
    /* Dynamic border left or outline based on status value */
    select[name="status"] option {
        background-color: var(--surface-pearl);
        color: var(--text-main);
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>
