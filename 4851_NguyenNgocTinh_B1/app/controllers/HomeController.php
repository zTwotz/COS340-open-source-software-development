<?php
require_once 'app/models/ProductModel.php';

class HomeController
{
    private $dataFile = 'app/data.json';
    private $products = [];

    public function __construct()
    {
        $this->loadData();
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
                        $item['image']
                    );
                }
            }
        }
    }

    public function index()
    {
        // Lấy 3 sản phẩm mới nhất để hiển thị ở trang chủ
        $featuredProducts = array_slice(array_reverse($this->products), 0, 3);
        include 'app/views/home/index.php';
    }
}
