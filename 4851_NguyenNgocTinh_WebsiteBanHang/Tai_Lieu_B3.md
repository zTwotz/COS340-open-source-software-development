52

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

BÀI 3.  XÂY DỰNG CHỨC NĂNG GIỎ HÀNG.

ĐẶT HÀNG, THANH TOÁN

Sau khi học xong bài này, học viên có thể:

•  Thiết  kế  cơ  sở  dữ  liệu  cho  giỏ  hàng  và  đặt  hàng,  tạo  các  bảng  orders  và

order_details trong MySQL.

•  Cập nhật ProductController để xử lý việc thêm sản phẩm vào giỏ hàng, quản lý

giỏ hàng và cập nhật số lượng sản phẩm.

•  Tạo các giao diện HTML cho giỏ hàng, cho phép người dùng thêm, xóa, cập nhật

sản phẩm và tiến hành đặt hàng.

•  Sử dụng session trong PHP để lưu trữ và quản lý thông tin giỏ hàng của người

dùng.

•  Cấu  hình  và  khởi  chạy  dự  án  PHP  trên  máy  chủ  local,  kiểm  tra  chức  năng  giỏ

hàng, đặt hàng và thanh toán.

Với các kỹ năng này, sinh viên sẽ có khả năng xây dựng và triển khai các chức năng

giỏ hàng, đặt hàng và thanh toán cho một website bán hàng.

3.1  Tạo bảng orders và order_details

Tạo bảng orders để lưu thông tin về các đơn hàng và bảng order_details để lưu chi

tiết các sản phẩm trong từng đơn hàng. Hai bảng này có mối quan hệ 1-nhiều.

SQL để tạo bảng orders

CREATE TABLE orders (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL,

    phone VARCHAR(20) NOT NULL,

    address TEXT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

BÀI 3 XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN  53

SQL để tạo bảng order_details

CREATE TABLE order_details (

    id INT AUTO_INCREMENT PRIMARY KEY,

    order_id INT NOT NULL,

    product_id INT NOT NULL,

    quantity INT NOT NULL,

    price DECIMAL(10, 2) NOT NULL,

    FOREIGN KEY (order_id) REFERENCES orders(id)

);

3.2  Cập nhật ProductController

Cập nhật ProductController để xử lý các yêu cầu liên quan đến giỏ hàng, bao gồm thêm

sản phẩm vào giỏ hàng, xóa sản phẩm khỏi giỏ hàng và cập nhật số lượng sản phẩm.

Thêm phương thức để xử lý việc thêm sản phẩm vào giỏ hàng và đặt hàng

ProductController.php

Thêm phương thức cart, addToCart, checkout và processCheckout.

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

54

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

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
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price,
$category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {

BÀI 3 XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN  55

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

56

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

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
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {

BÀI 3 XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN  57

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

    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Bắt đầu giao dịch

58

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

            $this->db->beginTransaction();

            try {
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name,
:phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // Lưu chi tiết đơn hàng vào bảng order_details
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id,
quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Commit giao dịch
                $this->db->commit();

                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }
}

BÀI 3 XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN  59

?>

60

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

3.3  Tạo các views tương ứng

File Cart.php

<?php include 'app/views/shares/header.php'; ?>

<h1>Giỏ hàng</h1>

<?php if (!empty($cart)): ?>
    <ul class="list-group">
        <?php foreach ($cart as $id => $item): ?>
            <li class="list-group-item">
                <h2><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
?></h2>
                <?php if ($item['image']): ?>
                    <img src="/webbanhang/<?php echo $item['image']; ?>" alt="Product
Image" style="max-width: 100px;">
                <?php endif; ?>
                <p>Giá: <?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-
8'); ?> VND</p>
                <p>Số lượng: <?php echo htmlspecialchars($item['quantity'],
ENT_QUOTES, 'UTF-8'); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>

<a href="/webbanhang/Product" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
<a href="/webbanhang/Product/checkout" class="btn btn-secondary mt-2">Thanh Toán</a>

<?php include 'app/views/shares/footer.php'; ?>

Checkout.php

<?php include 'app/views/shares/header.php'; ?>

<h1>Thanh toán</h1>

<form method="POST" action="/webbanhang/Product/processCheckout">
    <div class="form-group">
        <label for="name">Họ tên:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">

BÀI 3 XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN  61

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="address">Địa chỉ:</label>
        <textarea id="address" name="address" class="form-control"
required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Thanh toán</button>
</form>

<a href="/webbanhang/Product/cart" class="btn btn-secondary mt-2">Quay lại giỏ
hàng</a>

<?php include 'app/views/shares/footer.php'; ?>

orderConfirmation.php

<?php include 'app/views/shares/header.php'; ?>

<h1>Xác nhận đơn hàng</h1>
<p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
<a href="/webbanhang/Product/list" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>

<?php include 'app/views/shares/footer.php'; ?>

Cập nhật list.php

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

62

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

            <p>Danh mục: <?php echo htmlspecialchars($product->category_name,
ENT_QUOTES, 'UTF-8'); ?></p>
            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn
btn-warning">Sửa</a>
            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>"
class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm
này?');">Xóa</a>
            <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"
class="btn btn-primary">Thêm vào giỏ hàng</a>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'app/views/shares/footer.php'; ?>

3.4  Khởi tạo session

Đảm bảo rằng đã khởi tạo session ở đầu mỗi request:

Cập nhật file index.php

// Bắt đầu session ở đầu file index.php

session_start();

<?php
session_start();
require_once 'app/models/ProductModel.php';
// Product/add
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' :
'DefaultController';

// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// die ("controller=$controllerName - action=$action");

// Kiểm tra xem controller và action có tồn tại không

BÀI 3 XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN  63

if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Xử lý không tìm thấy controller
    die('Controller not found');
}

require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    // Xử lý không tìm thấy action
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));

3.5  Tiến hành khởi chạy và kiểm tra kết quả:

Trang danh sách sản phẩm:

64

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

Trang giỏ hàng:

BÀI 3 XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN  65

Trang thanh toán:

Xác nhận đơn hàng

66

BÀI 3XÂY DỰNG CHỨC NĂNG GIỎ HÀNG. ĐẶT HÀNG, THANH TOÁN

Kiểm tra database:

Bảng order_detail:

Bảng order

Thông tin đơn hàng đã đặt thành công
