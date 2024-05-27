<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductWithCategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    use ApiResponse;
    // use ApiResponse;

    
    public function index()
    {
        $products = Product::with(['promotion', 'category'])->get();

        return ProductWithCategoryResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (! $product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse(new ProductWithCategoryResource($product));
    }

    public function store(ProductRequest $request)
    {
        // $translatedTitle = translate($request->title, 'fr');

        // $product = new Product;

        // // Set the translated title, price, and details
        // $product->title = $translatedTitle;
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

        return $this->successResponse(new ProductWithCategoryResource($product), 'Product added successfully');
    }

    
    public function update($id, ProductRequest $request)
    {
        $product = Product::find($id);

        // if (! $product) {
        //     return $this->errorResponse('Product not found', 404);
        // }

        $updatedFields = [];

        if ($request->has('title')) {
            $product->title = $request->title;
            $updatedFields[] = 'title';
        }

        if ($request->has('price')) {
            $product->price = $request->price;
            $updatedFields[] = 'price';
        }

        if ($request->has('details')) {
            $product->details = $request->details;
            $updatedFields[] = 'details';
        }

        if ($request->hasFile('image')) {
            $originalFilename = $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $originalFilename);
            $product->image = $originalFilename;
            $updatedFields[] = 'image';
        }

        $product->save();

        // Check if the category exists and update category association
        if ($request->has('category_id')) {
            $category = Category::find($request->category_id);
            if (! $category) {
                return $this->errorResponse('Category not found', 404);
            }
            ProductCategory::updateOrCreate(
                ['product_id' => $product->id],
                ['category_id' => $request->category_id]
            );
            $updatedFields[] = 'category_id';
        }

        if (empty($updatedFields)) {
            return $this->errorResponse('No fields to update', 400);
        }

        $updatedFieldsString = implode(', ', $updatedFields);

        return $this->successResponse(new ProductWithCategoryResource($product), "Product updated successfully. Updated fields: {$updatedFieldsString}");
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->errorResponse('Product not found', 404);
        }

        $imageName = $product->image;
        $imagePath = public_path('images').'/'.$imageName;

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Remove associated category
        ProductCategory::where('product_id', $product->id)->delete();

        $product->delete();

        return $this->successResponse(new ProductWithCategoryResource($product), 'Product deleted successfully');
    }

    //Search about the productTitle
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return $this->errorResponse('Query parameter is required', 400);
        }

        $products = Product::where('title', 'LIKE', '%' . $query . '%')
            ->with(['promotion', 'category'])
            ->get();

        return ProductWithCategoryResource::collection($products);
    }
    

   
}
