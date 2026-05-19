<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Trang chủ sản phẩm — PUBLIC (ai cũng xem được)
    public function index()
    {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 8;
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($keyword)) {
            $products = $this->productModel->searchProducts($keyword, $page, $limit);
            $totalProducts = $this->productModel->getTotalSearchProducts($keyword);
        } else {
            $products = $this->productModel->getProductsPaginated($page, $limit);
            $totalProducts = $this->productModel->getTotalProducts();
        }

        $totalPages = ceil($totalProducts / $limit);
        $categories = $this->categoryModel->getCategories();

        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            $_SESSION['error_msg'] = "Không tìm thấy sản phẩm.";
            header('Location: ' . BASE_URL . '/Product');
            exit();
        }
    }

    // Thêm sản phẩm — YÊU CẦU ĐĂNG NHẬP
    public function add()
    {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error_msg'] = "Vui lòng đăng nhập để thêm sản phẩm.";
            header('Location: ' . BASE_URL . '/account/login');
            exit();
        }
        $categories = $this->categoryModel->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error_msg'] = "Vui lòng đăng nhập để thực hiện.";
            header('Location: ' . BASE_URL . '/account/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $image = "";

            // Check if file is uploaded
            // Image upload validation (controller-specific, not duplicated in model)
            $errors = [];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                try {
                    $image = $this->uploadImage($_FILES['image']);
                } catch (Exception $e) {
                    $errors['image'] = $e->getMessage();
                }
            }

            if (count($errors) > 0) {
                $categories = $this->categoryModel->getCategories();
                include 'app/views/product/add.php';
                return;
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = $this->categoryModel->getCategories();
                include 'app/views/product/add.php';
            } else {
                $_SESSION['success_msg'] = "Đã thêm sản phẩm thành công!";
                header('Location: ' . BASE_URL . '/Product');
                exit();
            }
        }
    }

    // Sửa sản phẩm — YÊU CẦU ĐĂNG NHẬP
    public function edit($id)
    {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error_msg'] = "Vui lòng đăng nhập để sửa sản phẩm.";
            header('Location: ' . BASE_URL . '/account/login');
            exit();
        }

        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            $_SESSION['error_msg'] = "Không tìm thấy sản phẩm.";
            header('Location: ' . BASE_URL . '/Product');
            exit();
        }
    }

    public function update()
    {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error_msg'] = "Vui lòng đăng nhập để thực hiện.";
            header('Location: ' . BASE_URL . '/account/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $existing_image = $_POST['existing_image'] ?? '';

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
            if (empty($category_id)) {
                $errors['category_id'] = 'Vui lòng chọn danh mục';
            }

            $image = $existing_image;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                try {
                    // Upload new image
                    $image = $this->uploadImage($_FILES['image']);
                    // Try to delete old image if it exists
                    if (!empty($existing_image) && file_exists($existing_image)) {
                        unlink($existing_image);
                    }
                } catch (Exception $e) {
                    $errors['image'] = $e->getMessage();
                }
            }

            if (count($errors) > 0) {
                $product = $this->productModel->getProductById($id);
                $categories = $this->categoryModel->getCategories();
                include 'app/views/product/edit.php';
                return;
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($edit) {
                $_SESSION['success_msg'] = "Cập nhật sản phẩm thành công!";
                header('Location: ' . BASE_URL . '/Product');
                exit();
            } else {
                $_SESSION['error_msg'] = "Đã xảy ra lỗi khi lưu sản phẩm.";
                header('Location: ' . BASE_URL . '/Product');
                exit();
            }
        }
    }

    // Xóa sản phẩm — YÊU CẦU ĐĂNG NHẬP
    public function delete($id)
    {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error_msg'] = "Vui lòng đăng nhập để thực hiện.";
            header('Location: ' . BASE_URL . '/account/login');
            exit();
        }

        if ($this->productModel->deleteProduct($id)) {
            $_SESSION['success_msg'] = "Đã xóa sản phẩm thành công!";
        } else {
            $_SESSION['error_msg'] = "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
        header('Location: ' . BASE_URL . '/Product');
        exit();
    }

    private function uploadImage($file)
    {
        $target_dir = "public/uploads/";

        // Create directory if not exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $filename = time() . "_" . basename($file["name"]);
        $target_file = $target_dir . $filename;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Limit file size (5MB)
        if ($file["size"] > 5 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn (Tối đa 5MB).");
        }

        // Allow certain formats
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($imageFileType, $allowed)) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG, GIF và WEBP.");
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $_SESSION['error_msg'] = "Không tìm thấy sản phẩm.";
            header('Location: ' . BASE_URL . '/Product');
            exit();
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

        $_SESSION['success_msg'] = "Đã thêm sản phẩm vào giỏ hàng!";
        header('Location: ' . BASE_URL . '/Product/cart');
        exit();
    }

    public function cart()
    {
        include 'app/views/product/cart.php';
    }

    public function clearCart()
    {
        unset($_SESSION['cart']);
        $_SESSION['success_msg'] = "Đã xóa toàn bộ giỏ hàng!";
        header('Location: ' . BASE_URL . '/Product/cart');
        exit();
    }

    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $id => $quantity) {
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$id]);
                } else {
                    $_SESSION['cart'][$id]['quantity'] = (int)$quantity;
                }
            }
            $_SESSION['success_msg'] = "Cập nhật giỏ hàng thành công!";
        }
        header('Location: ' . BASE_URL . '/Product/cart');
        exit();
    }

    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $_SESSION['success_msg'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
        }
        header('Location: ' . BASE_URL . '/Product/cart');
        exit();
    }

    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            // Validate form input
            if (empty($name) || empty($phone) || empty($address)) {
                $_SESSION['error_msg'] = "Vui lòng điền đầy đủ họ tên, số điện thoại và địa chỉ nhận hàng.";
                header('Location: ' . BASE_URL . '/Product/checkout');
                exit();
            }

            // Check if cart is empty
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                $_SESSION['error_msg'] = "Giỏ hàng của bạn đang trống.";
                header('Location: ' . BASE_URL . '/Product/cart');
                exit();
            }

            // Start database transaction
            $this->db->beginTransaction();

            try {
                // 1. Insert order record into orders table
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // 2. Insert detail records into order_details table
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // 3. Clear shopping cart session
                unset($_SESSION['cart']);

                // Commit transaction
                $this->db->commit();

                // Redirect to success confirmation page
                header('Location: ' . BASE_URL . '/Product/orderConfirmation');
                exit();
            } catch (Exception $e) {
                // Rollback transaction on failure
                $this->db->rollBack();
                $_SESSION['error_msg'] = "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
                header('Location: ' . BASE_URL . '/Product/checkout');
                exit();
            }
        }
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }
}
?>
