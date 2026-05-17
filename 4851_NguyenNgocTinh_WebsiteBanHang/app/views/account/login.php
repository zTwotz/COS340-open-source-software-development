<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 gradient-custom mt-5">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

          <form id="login-form">

            <div class="mb-md-5 mt-md-4 pb-3">
              <h2 class="fw-bold mb-2 text-uppercase">Đăng nhập</h2>
              <p class="text-white-50 mb-5">Vui lòng nhập tên đăng nhập và mật khẩu!</p>
              
              <div id="error-message" class="alert alert-danger" style="display: none;"></div>

              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="form-control form-control-lg" required />
              </div>

              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" required />
              </div>

              <button class="btn btn-outline-light btn-lg px-5 mt-3" type="submit">Đăng nhập</button>
            </div>

            <div>
              <p class="mb-0">Chưa có tài khoản? <a href="<?= BASE_URL ?>/account/register" class="text-white-50 fw-bold">Đăng ký ngay</a></p>
            </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    fetch('<?= BASE_URL ?>/account/checkLogin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.token) {
            localStorage.setItem('jwtToken', data.token);
            location.href = '<?= BASE_URL ?>/Product';
        } else {
            const errDiv = document.getElementById('error-message');
            errDiv.textContent = data.message || 'Đăng nhập thất bại';
            errDiv.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error logging in:', error);
        alert('Có lỗi kết nối xảy ra!');
    });
});
</script>
