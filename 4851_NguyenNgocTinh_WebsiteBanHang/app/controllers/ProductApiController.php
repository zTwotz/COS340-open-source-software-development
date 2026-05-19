<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/utils/JWTHandler.php');

class ProductApiController
{
    private $productModel;
    private $db;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    private function authenticate()
    {
        $headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
        if (!isset($headers['Authorization'])) {
            if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $headers['Authorization'] = $_SERVER['HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            }
        }

        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                $decoded = $this->jwtHandler->decode($jwt);
                return $decoded ? (array)$decoded : false;
            }
        }
        return false;
    }

    // Lấy danh sách sản phẩm — Public access (không yêu cầu JWT)
    public function index()
    {
        header('Content-Type: application/json');
        $products = $this->productModel->getProducts();
        echo json_encode($products);
    }

    // Lấy thông tin sản phẩm theo ID — Public access
    public function show($id)
    {
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }

    // Thêm sản phẩm mới — Yêu cầu JWT của Admin
    public function store()
    {
        header('Content-Type: application/json');
        
        $decoded = $this->authenticate();
        if (!$decoded) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized - Vui lòng đăng nhập để thực hiện']);
            return;
        }

        if (!isset($decoded['role']) || $decoded['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['message' => 'Forbidden - Chỉ tài khoản Admin mới có quyền thực hiện']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? null;
        $image = $data['image'] ?? '';

        $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        }
    }

    // Cập nhật sản phẩm theo ID — Yêu cầu JWT của Admin
    public function update($id)
    {
        header('Content-Type: application/json');

        $decoded = $this->authenticate();
        if (!$decoded) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized - Vui lòng đăng nhập để thực hiện']);
            return;
        }

        if (!isset($decoded['role']) || $decoded['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['message' => 'Forbidden - Chỉ tài khoản Admin mới có quyền thực hiện']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? null;

        // Preserve existing image — fetch from DB to prevent data loss
        $existingProduct = $this->productModel->getProductById($id);
        $image = $data['image'] ?? ($existingProduct ? $existingProduct->image : '');

        $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

        if ($result === true) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product update failed']);
        }
    }

    // Xóa sản phẩm theo ID — Yêu cầu JWT của Admin
    public function destroy($id)
    {
        header('Content-Type: application/json');

        $decoded = $this->authenticate();
        if (!$decoded) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized - Vui lòng đăng nhập để thực hiện']);
            return;
        }

        if (!isset($decoded['role']) || $decoded['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['message' => 'Forbidden - Chỉ tài khoản Admin mới có quyền thực hiện']);
            return;
        }

        $result = $this->productModel->deleteProduct($id);

        if ($result) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }
}
?>
