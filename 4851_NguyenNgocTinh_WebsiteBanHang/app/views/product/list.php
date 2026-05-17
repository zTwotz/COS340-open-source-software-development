<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1>Danh sách sản phẩm (API)</h1>
    <a href="<?= BASE_URL ?>/Product/add" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
    <ul class="list-group" id="product-list">
        <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
    </ul>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        alert('Vui lòng đăng nhập!');
        location.href = '<?= BASE_URL ?>/account/login';
        return;
    }

    fetch('<?= BASE_URL ?>/api/product', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    })
        .then(response => {
            if (response.status === 401) {
                alert('Phiên làm việc hết hạn hoặc không hợp lệ. Vui lòng đăng nhập lại!');
                localStorage.removeItem('jwtToken');
                location.href = '<?= BASE_URL ?>/account/login';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (!data) return;
            const productList = document.getElementById('product-list');
            data.forEach(product => {
                const productItem = document.createElement('li');
                productItem.className = 'list-group-item';
                
                let imageHtml = '';
                if(product.image) {
                    imageHtml = `<img src="<?= BASE_URL ?>/${product.image}" alt="Product Image" style="max-width: 100px;">`;
                }

                productItem.innerHTML = `
                    <h2><a href="<?= BASE_URL ?>/Product/show/${product.id}">${product.name}</a></h2>
                    ${imageHtml}
                    <p>${product.description}</p>
                    <p>Giá: ${product.price} VND</p>
                    <p>Danh mục: ${product.category_name}</p>
                    <a href="<?= BASE_URL ?>/Product/edit/${product.id}" class="btn btn-warning">Sửa</a>
                    <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Xóa</button>
                    <a href="<?= BASE_URL ?>/Product/addToCart/${product.id}" class="btn btn-primary">Thêm vào giỏ hàng</a>
                `;
                productList.appendChild(productItem);
            });
        });
});

function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`<?= BASE_URL ?>/api/product/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product deleted successfully') {
                location.reload();
            } else {
                alert('Xóa sản phẩm thất bại');
            }
        });
    }
}
</script>
