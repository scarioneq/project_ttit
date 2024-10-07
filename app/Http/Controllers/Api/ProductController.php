<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        if (!Gate::authorize('create', Product::class)) {
            return response()->json(['message' => 'Forbidden for you'], 403);
        }
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Не правильно заполнены строки', 'errors' => $validator->errors()], 422);
        }
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        Gate::authorize('update', Product::class);
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
        ]);
        $product->update($request->all());
        return response()->json(['message' => 'Product updated successfully']);

    }

    public function destroy(Request $request, Product $product)
    {
        Gate::authorize('delete', Product::class);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

}
