BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

Kiểm tra và đảm bảo các chức năng thêm, xóa, sửa và hiển thị sản phẩm hoạt động

đúng.

7.  Xử lý và quản lý dữ liệu:

Hiểu cách xử lý dữ liệu từ form và lưu trữ vào cơ sở dữ liệu.

Quản lý dữ liệu đầu vào và đầu ra, đảm bảo tính toàn vẹn và bảo mật dữ liệu.

Bài học này cung cấp một nền tảng vững chắc cho sinh viên trong việc xây dựng các

ứng dụng web động sử dụng PHP và MySQL. Sau bài học này, sinh viên sẽ có đủ kiến

thức và kỹ năng để tiếp tục xây dựng các chức năng phức tạp hơn cho ứng dụng web

của mình.

2.1  Sử dụng Laragon để quản lý cơ sở dữ liệu

MySQL

Laragon là một môi trường phát triển web dựa trên Windows, giúp người dùng dễ

dàng  cài  đặt  và  quản  lý  các  công  cụ  cần  thiết  như  Apache,  PHP  và  MySQL.  Laragon

cung cấp một giao diện đồ họa thân thiện và khả năng tùy chỉnh linh hoạt, cho phép

người dùng dễ dàng tạo và quản lý các môi trường phát triển web.

Khởi động chương trình cài đặt phần mềm Laragon và tiến hành cấu hình

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  23

Khi lựa chọn cấu hình, chỉ tích chọn MySQL. Trong trường hợp gặp lỗi do trùng cổng với

các dịch vụ khác, hãy thử thay đổi cổng sử dụng.

24

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

Sau khi thiết lập xong ấn Start All để khởi động. Kết quả như hình bên dưới:

2.2  Xây dựng Website bán hàng bằng PHP kết

nối với cơ sở dữ liệu MySQL

Xây dựng trang Web bán hàng với chức năng Hiển thị/Thêm/Xóa/Sửa sản phẩm.

2.2.1  Tạo dự án mới trong Laragon:

Chọn  Root  để  mở  thư  mục  gốc  nơi  Laragon  lưu  trữ  các  dự  án  web  của  bạn.  Thông

thường, thư mục này sẽ là C:\laragon\www.

Tạo dự án mang tên ‘webbanhang’ với cấu trúc thư mục như sau:

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  25

2.2.2  Tạo cơ sở dữ liệu

Tạo cơ sở dữ liệu có 2 bảng product và category

CREATE DATABASE my_store; USE my_store;
CREATE TABLE category ( id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, description TEXT

);

CREATE TABLE product (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(100) NOT NULL,
      description TEXT,
      price DECIMAL(10, 2) NOT NULL,

image VARCHAR(255) DEFAULT NULL;

    category_id INT,
    FOREIGN KEY (category_id) REFERENCES category(id)
);

Thêm file ‘database.php’ để kết nối database đã tạo trước đó trong thư mục có

‘/webbanhang/config/’

<?php
class Database {
    private $host = "localhost";
    private $db_name = "my_store";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this-
>db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

26

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

2.2.3  Xây dựng các Model tương ứng

Trong thư mục models, tạo các file ProductModel.php và CategoryModel.php để đại

diện cho các bảng trong cơ sở dữ liệu.

ProductModel.php

<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addProduct($name, $description, $price, $category_id)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  27

        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price,
category_id) VALUES (:name, :description, :price, :category_id)";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateProduct($id, $name, $description, $price, $category_id)
    {
        $query = "UPDATE " . $this->table_name . " SET name=:name,
description=:description, price=:price, category_id=:category_id WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);

        if ($stmt->execute()) {

28

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

            return true;
        }
        return false;
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>

CategoryModel.php

<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
?>

2.2.4  Khởi tạo các Controller tương ứng

Trong thư mục controllers, tạo các file ProductsController.php và

CategoryController.php.

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  29

ProductController.php

<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';

30

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

            $category_id = $_POST['category_id'] ?? null;

            $result = $this->productModel->addProduct($name, $description, $price,
$category_id);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {

                header('Location: /webbanhang/Product');
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            $edit = $this->productModel->updateProduct($id, $name, $description,
$price, $category_id);

            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  31

    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

}
?>

CategoryController.php

<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }
}
?>

32

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

2.2.5  Xây dựng giao diện hiển thị của trang web

2.2.5.1

Tạo các giao diện dùng chung:

Trong thư mục views tạo thêm thư mục shares, trong thư mục shares tạo thêm 2 file

header.php và footer.php

File header.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link
href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-
target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle
navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/">Danh sách sản
phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/add">Thêm sản
phẩm</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">

File footer.php

</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  33

    <script
src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></scrip
t>
    <script
src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

2.2.5.2

Tạo các views tương ứng cho product

Trong thư mục views, tạo các thư mục con products và categories, mỗi thư mục chứa

các file giao diện tương ứng.Trong product tạo thêm các file sau:

File ‘list.php’

<?php include 'app/views/shares/header.php'; ?>

<h1>Danh sách sản phẩm</h1>
<a href="/webbanhang/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
<ul class="list-group">
    <?php foreach ($products as $product): ?>
        <li class="list-group-item">
            <h2> <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" >
                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </h2>
            <p><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-
8'); ?></p>
            <p>Giá: <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8');
?></p>
            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn
btn-warning">Sửa</a>
            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>"
class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm
này?');">Xóa</a>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'app/views/shares/footer.php'; ?>

File add.php

<?php include 'app/views/shares/header.php'; ?>

<h1>Thêm sản phẩm mới</h1>

34

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/webbanhang/Product/save" onsubmit="return
validateForm();">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control"
required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01"
required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>"><?php echo
htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>
<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách
sản phẩm</a>

<?php include 'app/views/shares/footer.php'; ?>

File edit.php

<?php include 'app/views/shares/header.php'; ?>

<h1>Sửa sản phẩm</h1>
<?php if (!empty($errors)): ?>

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  35

    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/webbanhang/Product/update" onsubmit="return
validateForm();">
    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php
echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control"
required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
?></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01"
value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>"
required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>" <?php echo $category->id
== $product->category_id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8');
?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách
sản phẩm</a>

<?php include 'app/views/shares/footer.php'; ?>

36

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

2.2.6  Tiến hay khởi chạy dự án và thực nghiệm

Trang thêm sản phẩm:

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  37

Trang hiển thị sản phẩm:

38

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

Trang sửa sản phẩm:

Kiểm tra Database:

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  39

2.3  YÊU CẦU BỔ SUNG

Xây dựng thêm các chức năng chèn hình và hiển thị hình ảnh cho Product, xây dựng

các chức năng thêm xóa sửa của Category.

Hướng dẫn chèn hình và hiển thị hình ảnh:

1.  Cập nhật cơ sở dữ liệu

Thêm một cột image vào bảng product để lưu đường dẫn hình ảnh:

ALTER TABLE product ADD COLUMN image VARCHAR(255) DEFAULT NULL;

2.  Cập nhật model

Cập nhật phương thức addProduct và updateProduct để xử lý lưu đường dẫn hình

ảnh:

<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as
category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

40

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addProduct($name, $description, $price, $category_id, $image)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price,
category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateProduct($id, $name, $description, $price, $category_id,
$image)
    {

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  41

        $query = "UPDATE " . $this->table_name . " SET name=:name,
description=:description, price=:price, category_id=:category_id, image=:image WHERE
id=:id";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>

3.  Cập nhật controller

ProductController.php

Cập nhật phương thức save và update để xử lý upload hình ảnh:

<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');

42

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  43

                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price,
$category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {

                header('Location: /webbanhang/Product');
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description,
$price, $category_id, $image);

44

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "uploads/";

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

         // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
        throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !=
"jpeg" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        // Lưu file

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  45

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
    }

}
?>

4.  Cập nhật views:

app/views/product/add.php

Thêm trường upload hình ảnh vào form:

<?php include 'app/views/shares/header.php'; ?>

<h1>Thêm sản phẩm mới</h1>
<?php if (!empty($errors)): ?>

46

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data"
onsubmit="return validateForm();">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control"
required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01"
required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>"><?php echo
htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>
<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách
sản phẩm</a>

<?php include 'app/views/shares/footer.php'; ?>

app/views/product/edit.php

Thêm trường upload hình ảnh vào form và hiển thị hình ảnh hiện tại:

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  47

<?php include 'app/views/shares/header.php'; ?>

<h1>Sửa sản phẩm</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/webbanhang/Product/update" enctype="multipart/form-data"
onsubmit="return validateForm();">
    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php
echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control"
required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
?></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01"
value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>"
required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>" <?php echo $category->id
== $product->category_id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8');
?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image" class="form-control">

48

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

        <input type="hidden" name="existing_image" value="<?php echo $product->image;
?>">
        <?php if ($product->image): ?>
            <img src="/<?php echo $product->image; ?>" alt="Product Image" style="max-
width: 100px;">
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách
sản phẩm</a>

<?php include 'app/views/shares/footer.php'; ?>

Hiển thị hình ảnh trong danh sách sản phẩm

app/views/product/list.php

Thêm hiển thị hình ảnh vào danh sách sản phẩm:

<?php include 'app/views/shares/header.php'; ?>

<h1>Danh sách sản phẩm</h1>
<a href="/webbanhang/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
<ul class="list-group">
    <?php foreach ($products as $product): ?>
        <li class="list-group-item">
            <h2><a href="/webbanhang/Product/show/<?php echo $product->id; ?>"><?php
echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a></h2>
            <?php if ($product->image): ?>
                <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product
Image" style="max-width: 100px;">
            <?php endif; ?>
            <p><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-
8'); ?></p>
            <p>Giá: <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8');
?> VND</p>
            <p>Danh mục: <?php echo htmlspecialchars($product->category_name,
ENT_QUOTES, 'UTF-8'); ?></p>
            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn
btn-warning">Sửa</a>
            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>"
class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm
này?');">Xóa</a>
        </li>
    <?php endforeach; ?>
</ul>

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  49

<?php include 'app/views/shares/footer.php'; ?>

5.  Tiến khởi chạy dự án và kiểm tra kết quả:

Trang thêm sản phẩm:

50

BÀI 2TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA

Trang hiển thị danh sách sản phẩm

BÀI 2 TẠO CƠ SỞ DỮ LIỆU CHO WEBSITE BÁN HÀNG, XÂY DỰNG CHỨC NĂNG HIỂN THỊ/ THÊM/ XÓA/ SỬA  51

Trang sửa sản phẩm

Kiểm tra Database:

52