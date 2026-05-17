<?php

// Start session to store products (for Lesson 1)
session_start();

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Determine controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';

// Determine action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Check if controller file exists
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    die('Controller not found: ' . $controllerName);
}

require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();

// Check if action method exists
if (!method_exists($controller, $action)) {
    die('Action not found: ' . $action);
}

// Call action with remaining parameters
call_user_func_array([$controller, $action], array_slice($url, 2));
