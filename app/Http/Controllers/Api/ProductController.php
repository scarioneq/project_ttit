<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }
    public function store(ProductRequest $request)
    {
        Gate::authorize('create', Product::class);
        $product = Product::create($request->validated());
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        Gate::authorize('update', Product::class);
        $product->update($request->all());
        return response()->json(['message' => 'Продукт обновлен']);
    }

    public function destroy(Product $product)
    {
        Gate::authorize('delete', Product::class);
        $product->delete();
        return response()->json(['message' => 'Продукт удален']);
    }
}
