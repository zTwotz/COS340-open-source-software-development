<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/utils/JWTHandler.php');

class AccountController {
    private $accountModel;
    private $db;
    private $jwtHandler;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    function register(){
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    function save(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $fullName = trim($_POST['fullname'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';

            $errors =[];
            if(empty($username)){
                $errors['username'] = "Vui lòng nhập userName!";
            }
            if(empty($fullName)){
                $errors['fullname'] = "Vui lòng nhập fullName!";
            }
            if(empty($password)){
                $errors['password'] = "Vui lòng nhập password!";
            }
            if($password != $confirmPassword){
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa đúng";
            }
            
            // Kiểm tra username đã được đăng ký chưa
            $account = $this->accountModel->getAccountByUsername($username);

            if($account){
                $errors['account'] = "Tài khoản này đã có người đăng ký!";
            }

            if(count($errors) > 0){
                include_once 'app/views/account/register.php';
            }else{
                $password_hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password_hashed);
                if($result){
                    $_SESSION['success_msg'] = "Đăng ký tài khoản thành công! Vui lòng đăng nhập.";
                    header('Location: ' . BASE_URL . '/account/login');
                    exit();
                } else {
                    $errors['account'] = "Có lỗi xảy ra khi đăng ký!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    function logout(){
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_fullname']);
        unset($_SESSION['cart']);
        unset($_SESSION['coupon']);
        $_SESSION['success_msg'] = "Bạn đã đăng xuất thành công!";
        header('Location: ' . BASE_URL . '/product');
        exit();
    }

    // Traditional form POST login fallback (Bài 4) — for non-AJAX requests
    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/account/login');
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->accountModel->getAccountByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            // Clean up session cart to isolate user carts
            unset($_SESSION['cart']);
            unset($_SESSION['coupon']);

            $_SESSION['username'] = $user->username;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_fullname'] = $user->fullname;
            $_SESSION['success_msg'] = "Đăng nhập thành công! Chào mừng " . htmlspecialchars($user->fullname, ENT_QUOTES, 'UTF-8');
            header('Location: ' . BASE_URL . '/Product');
            exit();
        } else {
            $_SESSION['error_msg'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
            header('Location: ' . BASE_URL . '/account/login');
            exit();
        }
    }

    // JWT-based API login (Bài 6) — returns JSON token
    public function checkLogin()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';

        $user = $this->accountModel->getAccountByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            // Clean up session cart to isolate user carts
            unset($_SESSION['cart']);
            unset($_SESSION['coupon']);

            // Also set session for traditional web pages
            $_SESSION['username'] = $user->username;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_fullname'] = $user->fullname;

            $token = $this->jwtHandler->encode([
                'id' => $user->id, 
                'username' => $user->username,
                'role' => $user->role
            ]);

            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }
}
?>
