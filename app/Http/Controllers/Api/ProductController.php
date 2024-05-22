<?php

namespace App\Http\Controllers\Api;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    use ApiResponse;

    function index(){
    $products=Product::all();
    return $this->successResponse($products);
    }


    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse($product);
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
     
         return $this->successResponse($product,"Product added successfully");
    }
    function update($id , ProductRequest $request){
        $product = Product::find($id);
        
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        
        $product->title = $request->title;
        $product->price = $request->price;
        $product->details = $request->details;
        
        $product->save();
        
        return $this->successResponse($product,"Product updated successfully");
    }

    function destroy(Request $request, $id){
        $product = Product::find($id);
        
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        
        $imageName = $product->image;
        
        $imagePath = public_path('images') . '/' . $imageName;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $product->delete();
        
        return $this->successResponse($product, 'Product deleted successfully');
    }
    
}
