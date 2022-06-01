<?php

namespace App\Services\Interfaces;

use App\Models\Category;

interface CategoryServiceInterface
{
    public function getAllCategories();
    public function getCategory($id);
    public function create(array $data);
    public function update(Category $category,array $data);
    public function destroy(Category $category);
}