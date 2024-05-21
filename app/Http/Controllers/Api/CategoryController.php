<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;
use App\Http\Requests\CategoryRequest;


class CategoryController extends Controller
{
    use ApiResponse;

    function index(){
    $categories=Category::all();
    return $this->successResponse($categories);
    }


    public function show($id)
    {
        $category=Category::find($id);

        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }

        return $this->successResponse($category);
    }


    function store(CategoryRequest $request)
    {
         $category = new Category;
         $category->name = $request->name;
         $category->description = $request->description;

     
         $category->save();
     
         return $this->successResponse($category,"Category added successfully");
    }
    function update($id , CategoryRequest $request){
        $category = Category::find($id);
        
        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }
        
        $category->name = $request->name;
        $category->description = $request->description;
        
        $category->save();
        
        return $this->successResponse($category,"Category updated successfully");
    }

    function destroy(Request $request, $id){
        $category = Category::find($id);
        
        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }
        

        $category->delete();
        
        return $this->successResponse($category, 'Category deleted successfully');
    }
    
}

