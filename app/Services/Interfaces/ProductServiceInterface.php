<?php

namespace App\Services\Interfaces;

use App\Models\Product;

interface ProductServiceInterface
{
    public function getAllProducts();
    public function getProduct($id);
    public function create(array $data);
    public function update(Product $product,array $data);
    public function update_image(Product $product,array $data);
    public function destroy(Product $product);
}