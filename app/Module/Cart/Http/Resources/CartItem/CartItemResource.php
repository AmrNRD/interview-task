<?php

namespace App\Module\Cart\Http\Resources\CartItem;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use \App\Module\Cart\Http\Resources\Cart\CartResource;
use \App\Module\Product\Http\Resources\Product\ProductResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request):array
    {
        return [

			'id'  =>  $this->id,
			'cart_id'  =>  $this->cart_id,
			'product_id'  =>  $this->product_id,
			'quantity'  =>  $this->quantity,
            'vat'  =>  $this->vat,
            'total'  =>  $this->total,
            'cart'  =>  $this->when($this->relationLoaded('cart'),function (){ return new CartResource($this->cart);}),
			'product'  =>  $this->when($this->relationLoaded('product'),function (){ return new ProductResource($this->product);}),
        ];
    }
}
