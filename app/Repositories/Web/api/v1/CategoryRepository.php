<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function getAllCategories()
    {
        $results = Category::orderBy('created_at','desc');
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
     * @return Category
     */
    public function create(array $data) : Category
    {
        $category = Category::create([
            'name'   => $data['name'],
            'mm_name'   => isset($data['mm_name']) ? $data['mm_name'] : null ,
            'created_by' => auth()->user()->id
        ]);
        return $category;
    }

    /**
     * @param Category  $category
     * @param array $data
     *
     * @return mixed
     */
    public function update(Category $category, array $data) : Category
    {
        $category->name = isset($data['name']) ? $data['name'] : $category->name ;
        $category->mm_name = isset($data['mm_name']) ? $data['mm_name'] : $category->mm_name ;
       
        if ($category->isDirty()) {
            $category->updated_by = auth()->user()->id;
            $category->save();
        }
        return $category->refresh();
    }

    /**
     * @param Category $category
     */
    public function destroy(Category $category)
    {
        $deleted = $this->deleteById($category->id);

        if ($deleted) {
            $category->deleted_by = auth()->user()->id;
            $category->save();
        }
    }
}
