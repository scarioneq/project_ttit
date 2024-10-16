<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('products')
            ->where('user_id', $request->user()->id)
            ->get();

        return OrderResource::collection($orders);
    }

    public function add(StoreOrderRequest $request)
    {
        $request->validateCart();
        $cartItems = auth()->user()->cart;
        $totalAmount = $cartItems->sum('price');
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
        ]);
        foreach ($cartItems as $item) {
            $order->products()->attach($item->product_id, [
                'price' => $item->price,
            ]);
        }
        auth()->user()->cart()->delete();

        return new OrderResource($order);
    }
}
