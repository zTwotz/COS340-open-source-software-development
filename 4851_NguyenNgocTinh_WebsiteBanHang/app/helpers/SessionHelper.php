<?php

class SessionHelper {
    public static function isLoggedIn() {
        return isset($_SESSION['username']);
    }

    public static function isAdmin() {
        return isset($_SESSION['username']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function getCSRFToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCSRFToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}

