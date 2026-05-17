<?php

require_once 'app/models/ProductModel.php';

class ProductController
{
    private $dataFile = 'app/data.json';
    private $products = [];

    public function __construct()
    {
        $this->loadData();
    }

    private function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    private function redirectNonAdmin()
    {
        if (!$this->isAdmin()) {
            $_SESSION['error_msg'] = 'Bạn không có quyền thực hiện hành động này!';
            header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index');
            exit();
        }
    }

    private function loadData()
    {
        if (file_exists($this->dataFile)) {
            $jsonContent = file_get_contents($this->dataFile);
            $data = json_decode($jsonContent, true);
            if (is_array($data)) {
                foreach ($data as $item) {
                    $this->products[] = new ProductModel(
                        $item['id'],
                        $item['name'],
                        $item['description'],
                        $item['price'],
                        $item['image'],
                        $item['category'] ?? 'Chưa phân loại'
                    );
                }
            }
        }
    }

    private function saveData()
    {
        $data = [];
        foreach ($this->products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'image' => $product->getImage(),
                'category' => $product->getCategory()
            ];
        }
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $minPrice = $_GET['min_price'] ?? '';
        $maxPrice = $_GET['max_price'] ?? '';
        $category = isset($_GET['category']) ? trim($_GET['category']) : '';

        $filteredProducts = array_filter($this->products, function($product) use ($search, $minPrice, $maxPrice, $category) {
            $matchSearch = ($search === '') || stripos($product->getName(), $search) !== false;
            $matchMin = ($minPrice === '') || $product->getPrice() >= (float)$minPrice;
            $matchMax = ($maxPrice === '') || $product->getPrice() <= (float)$maxPrice;
            $matchCategory = ($category === '') || (trim($product->getCategory()) === $category);
            return $matchSearch && $matchMin && $matchMax && $matchCategory;
        });

        $products = array_values($filteredProducts);
        $categories = ["Điện thoại", "Laptop", "Phụ kiện", "Máy tính bảng", "Khác", "Chưa phân loại"];
        
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->getProductById($id);
        if (!$product) {
            header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index');
            exit();
        }
        include 'app/views/product/show.php';
    }

    public function add()
    {
        $this->redirectNonAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = $_POST['price'];
            $category = $_POST['category'] ?? 'Khác';
            
            // --- VALIDATION LOGIC ---
            if (empty($name) || empty($price)) {
                $error = "Tên sản phẩm và Giá không được để trống!";
            } elseif (!is_numeric($price) || $price <= 0) {
                $error = "Giá sản phẩm phải là một số lớn hơn 0!";
            } else {
                $image = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $filename = $_FILES['image']['name'];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    
                    if (!in_array($ext, $allowed)) {
                        $error = "Định dạng file không hỗ trợ! Chỉ cho phép: " . implode(', ', $allowed);
                    } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                        $error = "File ảnh quá lớn! Vui lòng chọn file dưới 2MB.";
                    } else {
                        $target_dir = "public/uploads/";
                        $image = time() . "_" . basename($_FILES["image"]["name"]);
                        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
                    }
                }

                if (!isset($error)) {
                    $id = count($this->products) > 0 ? max(array_map(function($p) { return $p->getId(); }, $this->products)) + 1 : 1;
                    $newProduct = new ProductModel($id, $name, $description, $price, $image, $category);
                    $this->products[] = $newProduct;
                    $this->saveData();
                    $_SESSION['success_msg'] = 'Đã thêm sản phẩm thành công!';
                    header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index');
                    exit();
                }
            }
        }
        include 'app/views/product/add.php';
    }

    public function edit($id)
    {
        $this->redirectNonAdmin();

        $product = $this->getProductById($id);
        if (!$product) {
            die('Product not found');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $price = $_POST['price'];
            
            if (empty($name) || empty($price)) {
                $error = "Tên sản phẩm và Giá không được để trống!";
            } elseif (!is_numeric($price) || $price <= 0) {
                $error = "Giá sản phẩm phải là số dương!";
            } else {
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    
                    if (!in_array($ext, $allowed)) {
                        $error = "Định dạng file không hỗ trợ!";
                    } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                        $error = "Dung lượng ảnh tối đa là 2MB!";
                    } else {
                        $target_dir = "public/uploads/";
                        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
                        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $imageName);
                        $product->setImage($imageName);
                    }
                }

                if (!isset($error)) {
                    $product->setName($name);
                    $product->setDescription(trim($_POST['description']));
                    $product->setPrice($price);
                    $product->setCategory($_POST['category'] ?? 'Khác');
                    $this->saveData();
                    $_SESSION['success_msg'] = 'Đã cập nhật sản phẩm thành công!';
                    header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index');
                    exit();
                }
            }
        }
        include 'app/views/product/edit.php';
    }

    public function delete($id)
    {
        $this->redirectNonAdmin();

        foreach ($this->products as $key => $product) {
            if ($product->getId() == $id) {
                unset($this->products[$key]);
                break;
            }
        }
        $this->products = array_values($this->products);
        $this->saveData();
        $_SESSION['success_msg'] = 'Đã xóa sản phẩm thành công!';
        header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Product/index');
        exit();
    }

    private function getProductById($id)
    {
        foreach ($this->products as $product) {
            if ($product->getId() == $id) {
                return $product;
            }
        }
        return null;
    }
}
