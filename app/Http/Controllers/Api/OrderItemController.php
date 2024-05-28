<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderItemController extends Controller
{

    public function index()
{
    $orderItems = OrderItem::with('product')->get();
    return response()->json($orderItems);
}



    public function store(Request $request)
    {
        $orderItem = OrderItem::create($request->all());
        return response()->json($orderItem, 201);
    }


    public function show($user_id)
{
    $orders = OrderItem::where('user_id', $user_id)->get();
    return response()->json($orderItem);
}


    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($request->all());
        return response()->json($orderItem);
    }


    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();
        return response()->json(null, 204);
    }
}

//push
