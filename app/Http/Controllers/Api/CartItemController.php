<?php

namespace App\Http\Controllers\Api;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CartItemController extends Controller
{

    public function index()
    {
        $cartItems = CartItem::with('product')->get();
        return response()->json($cartItems);
    }


    public function show($id)
{
    $cartItems = CartItem::where('cart_id', $id)
                         ->with('product')
                         ->get();

    return response()->json($cartItems);
}



    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update($request->all());
        return response()->json($cartItem);
    }


    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        return response()->json(null, 204);
    }
}
