<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductWithCategoryResource;

class ProductController extends Controller
{
    use ApiResponse;

    function index(){
        $products = Product::with('category')->get();
        return ProductWithCategoryResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse(new ProductWithCategoryResource($product));
    }

    function store(ProductRequest $request)
    {
        $product = new Product;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->details = $request->details;

        if ($request->hasFile('image')) {
            $originalFilename = $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $originalFilename);
            $product->image = $originalFilename;
        } else {
            $product->image = 'default.jpg';
        }

        $product->save();

        // Associate product with a category
        if ($request->category_id) {
            ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $request->category_id,
            ]);
        }

        return $this->successResponse(new ProductWithCategoryResource($product), "Product added successfully");
    }

    function update($id, ProductRequest $request)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        $product->title = $request->title;
        $product->price = $request->price;
        $product->details = $request->details;

        if ($request->hasFile('image')) {
            $originalFilename = $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $originalFilename);
            $product->image = $originalFilename;
        }

        $product->save();

        // Update category association
        if ($request->category_id) {
            ProductCategory::updateOrCreate(
                ['product_id' => $product->id],
                ['category_id' => $request->category_id]
            );
        }

        return $this->successResponse(new ProductWithCategoryResource($product), "Product updated successfully");
    }

    function destroy(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        $imageName = $product->image;
        $imagePath = public_path('images') . '/' . $imageName;

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Remove associated category
        ProductCategory::where('product_id', $product->id)->delete();

        $product->delete();

        return $this->successResponse(new ProductWithCategoryResource($product), 'Product deleted successfully');
    }
}
