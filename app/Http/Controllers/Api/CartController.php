<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 429);
        }

        Cart::create(
            [
                'user_id' => Auth::id(),
                'product_id' => $product_id,
            ],
        );

        return response()->json(['message' => 'Product add to card'], 201);
    }

    // Просмотр своей корзины
    public function view()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product') // Предполагается, что у вас есть связь с моделью Product
            ->get();

        $responseData = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'description' => $item->product->description,
                'price' => $item->product->price,
            ];
        });

        return response()->json(['data' => $responseData], 200);
    }

    // Удаление товара из корзины
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Forbidden for you'], 403);
        }
        $cartItem->delete();
        return response()->json(['message' => 'Item removed from cart'], 200);
    }
}


