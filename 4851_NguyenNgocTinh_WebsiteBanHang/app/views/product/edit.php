<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1>Sửa sản phẩm (API)</h1>
    <form id="edit-product-form">
        <input type="hidden" id="id" name="id">
        <!-- Add existing image hidden input to preserve the image -->
        <input type="hidden" id="existing_image" name="existing_image">
        
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
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </form>

    <a href="<?= BASE_URL ?>/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const productId = <?= isset($product) ? $product->id : (isset($editId) ? $editId : 0) ?>;

    if (!productId) {
        alert("Không tìm thấy ID sản phẩm");
        return;
    }

    fetch(`<?= BASE_URL ?>/api/product/${productId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('price').value = data.price;
            if(document.getElementById('existing_image')) {
                document.getElementById('existing_image').value = data.image || '';
            }

            // Then fetch categories
            fetch('<?= BASE_URL ?>/api/category')
                .then(response => response.json())
                .then(categories => {
                    const categorySelect = document.getElementById('category_id');
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        if(category.id == data.category_id) {
                            option.selected = true;
                        }
                        categorySelect.appendChild(option);
                    });
                });
        });

    document.getElementById('edit-product-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        fetch(`<?= BASE_URL ?>/api/product/${jsonData.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product updated successfully') {
                location.href = '<?= BASE_URL ?>/Product';
            } else {
                alert('Cập nhật sản phẩm thất bại');
            }
        })
        .catch(error => {
            alert('Cập nhật sản phẩm thất bại: ' + error);
        });
    });
});
</script>
