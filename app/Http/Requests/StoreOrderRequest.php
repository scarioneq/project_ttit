<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }

    public function validateCart()
    {
        if (auth()->user()->cart->isEmpty()) {
            abort(422, 'Корзина не найдена');
        }
    }
}
