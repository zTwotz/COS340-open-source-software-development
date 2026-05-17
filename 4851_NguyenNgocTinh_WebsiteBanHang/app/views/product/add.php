<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1>Thêm sản phẩm mới (API)</h1>
    <form id="add-product-form">
        <div class="form-group mb-3">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="form-group mb-3">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <!-- Các danh mục sẽ được tải từ API và hiển thị tại đây -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
    </form>

    <a href="<?= BASE_URL ?>/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('<?= BASE_URL ?>/api/category')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        });

    document.getElementById('add-product-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        fetch('<?= BASE_URL ?>/api/product', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product created successfully') {
                location.href = '<?= BASE_URL ?>/Product';
            } else {
                alert('Thêm sản phẩm thất bại: ' + (data.message || JSON.stringify(data.errors)));
            }
        })
        .catch(error => {
            console.error('Error parsing JSON:', error);
            alert('Lỗi: Không thể phân tích JSON từ phản hồi của máy chủ.');
        });
    });
});
</script>
