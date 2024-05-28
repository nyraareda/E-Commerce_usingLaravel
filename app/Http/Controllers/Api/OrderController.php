<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }


    public function store(Request $request)
    {
        $order = Order::create($request->all());
        return response()->json($order, 201);
    }


    public function show($user_id)
{
    $orders = Order::where('user_id', $user_id)->get();
    return response()->json($orders);
}



    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json($order);
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }
}
