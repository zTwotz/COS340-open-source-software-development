<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Đăng ký tài khoản</h4>
                </div>
                <div class="card-body p-5">
                    <?php
                    if (isset($errors)) {
                        echo "<div class='alert alert-danger'><ul>";
                        foreach ($errors as $err) {
                            echo "<li>$err</li>";
                        }
                        echo "</ul></div>";
                    }
                    ?>
                    <form class="user" action="<?= BASE_URL ?>/account/save" method="post">
                        <div class="form-group row mb-3">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="username">Tên đăng nhập</label>
                                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="fullname">Họ và tên</label>
                                <input type="text" class="form-control form-control-user" id="fullname" name="fullname" placeholder="Họ và tên" required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="confirmpassword">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control form-control-user" id="confirmpassword" name="confirmpassword" placeholder="Xác nhận Password" required>
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <button class="btn btn-primary btn-block px-5">Đăng ký</button>
                        </div>
                        <div class="text-center mt-3">
                            <p>Đã có tài khoản? <a href="<?= BASE_URL ?>/account/login">Đăng nhập ngay</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
