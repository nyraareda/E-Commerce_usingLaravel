<?php

namespace App\Http\Controllers\Api;
use App\Models\Promotion;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;
use App\Http\Resources\PromotionResource;
use App\Http\Requests\PromotionRequest;
use Carbon\Carbon;

class PromotionController extends Controller
{
    use ApiResponse;
    public function index(){
        $promotions = Promotion::all();
        return PromotionResource::collection($promotions);
    }

    public function show($id)
    {
        $promotion = Promotion::with('product')->findOrFail($id);
        return new PromotionResource($promotion);
    }

    function store(PromotionRequest $request)
    {
        $productId = $request->product_id;


        $existingPromotion = Promotion::where('product_id', $productId)->exists();

        if ($existingPromotion) {

            return $this->errorResponse('A promotion already exists for this product id = ' . $productId .' of products' , 400);
        
        }
        $startDate = $request->input('start_date', Carbon::now()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->addWeek()->toDateString());

        $promotion = new Promotion;
        $promotion->product_id = $request->product_id;
        $promotion->discount_percentage = $request->discount_percentage;
        $promotion->start_date = $startDate;
        $promotion->end_date = $endDate;
    
        
        $promotion->save();
    
        return $this->successResponse(new PromotionResource ($promotion), 'Promotion created successfully', 200);
    }


    function update($id , PromotionRequest $request){
        $promotion = Promotion::find($id);
        
        if (!$promotion) {
            return $this->errorResponse('this promotion of this id (' . $id . ') is not found', 404);
        }
        
        $promotion->discount_percentage = $request->discount_percentage;

        $promotion->save();
        
        return $this->successResponse($promotion,"The promotion is updated successfully");
    }

    function destroy(Request $request, $id){
        $promotion = Promotion::find($id);
        
        if (!$promotion) {
            return $this->errorResponse('this promotion of this id (' . $id . ') is not found', 404);
        }

        $promotion->delete();
        
        return $this->successResponse($promotion, 'Promotion deleted successfully');
    }

   
}
