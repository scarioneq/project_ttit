<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Product $product)
    {
        if (!$product) {
            return response()->json(['message' => 'Продукт не найден'], 404);
        }
        Cart::create(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'price' => $product->price,
                'description' => $product->description,
            ],
        );
        return response()->json(['message' => 'Продукт добавлен в корзину'], 201);
    }

    public function view()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return CartItemResource::collection($cartItems);
    }

    public function remove($cartItemId)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('id', $cartItemId)->where('user_id', $userId)->first();
        if (!$cartItem) {
            return response()->json(['message' => 'Продукта нет в вашей корзине'], 404);
        }
        $cartItem->delete();
        return response()->json(['message' => 'Продукт удален из корзины'], 200);
    }
}


