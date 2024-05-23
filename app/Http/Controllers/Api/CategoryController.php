<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $categories = Category::all();
        return $this->successResponse($categories);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }

        return $this->successResponse($category);
    }

    public function store(CategoryRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        // Associate products with category if provided
        if ($request->product_ids) {
            foreach ($request->product_ids as $product_id) {
                ProductCategory::create([
                    'product_id' => $product_id,
                    'category_id' => $category->id,
                ]);
            }
        }

        return $this->successResponse($category, "Category added successfully");
    }

    public function update($id, CategoryRequest $request)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        // Update associations with products if provided
        if ($request->product_ids) {
            // Remove existing associations
            ProductCategory::where('category_id', $category->id)->delete();
            // Add new associations
            foreach ($request->product_ids as $product_id) {
                ProductCategory::create([
                    'product_id' => $product_id,
                    'category_id' => $category->id,
                ]);
            }
        }

        return $this->successResponse($category, "Category updated successfully");
    }

    public function destroy(Request $request, $id)
{
    $category = Category::find($id);

    if (!$category) {
        return $this->errorResponse('Category not found', 404);
    }

    // Delete all products associated with the category
    $category->products()->delete();

    // Remove associations in pivot table if any
    ProductCategory::where('category_id', $category->id)->delete();

    // Delete the category itself
    $category->delete();

    return $this->successResponse($category, 'Category and associated products deleted successfully');
}

}
