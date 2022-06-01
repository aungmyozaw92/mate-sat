<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Category;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\CategoryRepository;
use App\Services\Interfaces\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories();
    }

    public function getCategory($id)
    {
        return $this->categoryRepository->getCategory($id);
    }
    
    public function create(array $data)
    {        
        return $this->categoryRepository->create($data);
    }

    public function update(Category $category,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->categoryRepository->update($category, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Category');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            $result = $this->categoryRepository->destroy($category);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Category');
        }
        DB::commit();
        
        return $result;
    }

}