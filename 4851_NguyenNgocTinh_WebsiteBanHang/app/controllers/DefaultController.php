<?php
class DefaultController
{
    public function index()
    {
        header('Location: ' . BASE_URL . '/Product');
        exit();
    }
}
?>
