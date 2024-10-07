<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('products')->where('user_id', $request->user()->id)->get();

        $result = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'products' => $order->products->pluck('id'),
                'order_price' => $order->products->sum('price'),
            ];
        });
        return response()->json($result);
    }

    public function add(Request $request)
    {
        $cartItems = auth()->user()->cart;

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        // Вычисляем общую сумму
        $totalAmount = $cartItems->sum('price');


        // Создаем заказ с указанием total_amount
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
        ]);

        // Добавляем продукты в промежуточную таблицу
        foreach ($cartItems as $item) {
            $order->products()->attach($item->product_id, [
                'price' => $item->price,
            ]);
        }

        // Очищаем корзину после оформления заказа
        auth()->user()->cart()->delete();

        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }
}
