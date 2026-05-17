<?php

class AccountController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Demo logic với dữ liệu cứng theo yêu cầu
            if ($password === '123') {
                if ($email === 'admin@gmail.com') {
                    $_SESSION['user'] = ['email' => $email, 'role' => 'admin', 'name' => 'Administrator'];
                    header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/');
                    exit();
                } elseif ($email === 'user@gmail.com') {
                    $_SESSION['user'] = ['email' => $email, 'role' => 'user', 'name' => 'Thành viên'];
                    header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/');
                    exit();
                }
            }
            
            $error = "Email hoặc mật khẩu không đúng!";
        }
        include 'app/views/account/login.php';
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /4851_NguyenNgocTinh_PTPM_MNM/4851_NguyenNgocTinh_B1/Account/login');
        exit();
    }
}
