<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\ProductService;
use App\Http\Requests\Web\Product\CreateProductRequest;
use App\Http\Requests\Web\Product\UpdateProductRequest;
use App\Http\Resources\Web\api\v1\Product\ProductResource;
use App\Http\Requests\Web\Product\UpdateProductImageRequest;
use App\Http\Resources\Web\api\v1\Product\ProductCollection;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    protected $productService;

    /**
     * AgentController constructor.
     *
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = $this->productService->create($request->all());
        return new ProductResource($product->load(['category']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product->load(['category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->all());
        return new ProductResource($product->load(['category']));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_image(UpdateProductImageRequest $request, Product $product)
    {
        $this->productService->update_image($product, $request->only(['file']));
        return new ProductResource($product->load(['category']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productService->destroy($product);
        return response()->json(['status' => 1,'message' => 'Successful deleted'], Response::HTTP_OK);
    }
}
