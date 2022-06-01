<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    public function getAllProducts()
    {
        $results = Product::with(['category'])
                    ->filter(request()->only(['search']))
                    ->orderBy('created_at','desc');
        if (request()->has('paginate')) {
            $results = $results->paginate(request()->get('paginate'));
        } else {
            $results = $results->get();
        }
        return $results;
    }

    /**
     * @param array $data
     *
     * @return Product
     */
    public function create(array $data) : Product
    {
        if (isset($data['file']) && $data['file']) {
            $attachmentRepository = new AttachmentRepository();
            $image_path =  $attachmentRepository->uploadToSpace($data, 'product');
        }

        $product = Product::create([
            'category_id'  => $data['category_id'],
            'name'  => $data['name'],
            'mm_name'  => isset($data['mm_name']) ? $data['mm_name'] : null,
            'item_code'  => $data['item_code'],
            'price'  => $data['price'],
            'description'  => isset($data['description']) ? $data['description'] : null,
            'image_path'  => $image_path,
            'is_available'  => isset($data['is_available']) ? $data['is_available'] : false,
            'exclusive_bottle'  => isset($data['exclusive_bottle']) ? $data['exclusive_bottle'] : false,
            'created_by' => auth()->user()->id
        ]);

        return $product;
    }

    /**
     * @param Product  $product
     * @param array $data
     *
     * @return mixed
     */
    public function update(Product $product, array $data) : Product
    {
        if (isset($data['file']) && $data['file']) {
            $attachmentRepository = new AttachmentRepository();
            $image_path =  $attachmentRepository->uploadToSpace($data, 'product');
            if ($image_path) {
                Storage::disk('dospace')->delete($product->image_path);
            }
        }
        $product->category_id = isset($data['category_id']) ? $data['category_id'] : $product->category_id ;
        $product->name = isset($data['name']) ? $data['name'] : $product->name ;
        $product->mm_name = isset($data['mm_name']) ? $data['mm_name'] : $product->mm_name ;
        $product->item_code = isset($data['item_code']) ? $data['item_code'] : $product->item_code ;
        $product->price = isset($data['price']) ? $data['price'] : $product->price ;
        $product->description = isset($data['description']) ? $data['description'] : $product->description ;
        $product->image_path = isset($data['image_path']) ? $image_path : $product->image_path ;
        $product->is_available = isset($data['is_available']) ? $data['is_available'] : $product->is_available ;
        $product->exclusive_bottle = isset($data['exclusive_bottle']) ? $data['exclusive_bottle'] : $product->exclusive_bottle ;
       
        if ($product->isDirty()) {
            $product->updated_by = auth()->user()->id;
            $product->save();
        }
        return $product->refresh();
    }

     /**
     * @param Product  $product
     * @param array $data
     *
     * @return mixed
     */
    public function update_image(Product $product, array $data) : Product
    {
        if (isset($data['file']) && $data['file']) {
            $attachmentRepository = new AttachmentRepository();
            $image_path =  $attachmentRepository->uploadToSpace($data, 'product');
            if ($image_path) {
                Storage::disk('dospace')->delete($product->image_path);
            }
        }
        $product->image_path =  $image_path ;

        if ($product->isDirty()) {
            $product->updated_by = auth()->user()->id;
            $product->save();
        }
        return $product->refresh();
    }
    
    /**
     * @param Product $product
     */
    public function destroy(Product $product)
    {
        $deleted = $this->deleteById($product->id);

        if ($deleted) {
            $product->deleted_by = auth()->user()->id;
            $product->save();
        }
    }
}
