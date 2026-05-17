<?php
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

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        include 'app/views/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $result = $this->categoryModel->addCategory($name, $description);

            if (is_array($result)) {
                $errors = $result;
                include 'app/views/category/add.php';
            } else {
                $_SESSION['success_msg'] = "Đã thêm danh mục thành công!";
                header('Location: ' . BASE_URL . '/Category/list');
                exit();
            }
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);

        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            $_SESSION['error_msg'] = "Không tìm thấy danh mục.";
            header('Location: ' . BASE_URL . '/Category/list');
            exit();
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $result = $this->categoryModel->updateCategory($id, $name, $description);

            if (is_array($result)) {
                $errors = $result;
                $category = $this->categoryModel->getCategoryById($id);
                include 'app/views/category/edit.php';
            } else {
                $_SESSION['success_msg'] = "Cập nhật danh mục thành công!";
                header('Location: ' . BASE_URL . '/Category/list');
                exit();
            }
        }
    }

    public function delete($id)
    {
        $result = $this->categoryModel->deleteCategory($id);

        if ($result === true) {
            $_SESSION['success_msg'] = "Đã xóa danh mục thành công!";
        } else {
            $_SESSION['error_msg'] = is_string($result) ? $result : "Đã xảy ra lỗi khi xóa danh mục.";
        }

        header('Location: ' . BASE_URL . '/Category/list');
        exit();
    }
}
?>
