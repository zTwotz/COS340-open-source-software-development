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
        header('Location: ' . BASE_URL . '/product');
        exit();
    }

    public function checkLogin()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';

        $user = $this->accountModel->getAccountByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            $token = $this->jwtHandler->encode(['id' => $user->id, 'username' => $user->username]);

            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }
}
?>
