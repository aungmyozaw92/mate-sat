<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Product;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\ProductRepository;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProduct($id)
    {
        return $this->productRepository->getProduct($id);
    }
    
    public function create(array $data)
    {        
        return $this->productRepository->create($data);
    }

    public function update(Product $product,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->productRepository->update($product, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Product');
        }
        DB::commit();

        return $result;
    }
    
    public function update_image(Product $product,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->productRepository->update_image($product, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Product');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $result = $this->productRepository->destroy($product);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Product');
        }
        DB::commit();
        
        return $result;
    }

}