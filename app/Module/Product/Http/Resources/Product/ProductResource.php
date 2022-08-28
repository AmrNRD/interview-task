<?php

namespace App\Module\Product\Http\Resources\Product;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use \App\Module\Store\Http\Resources\Store\StoreResource;

class ProductResource extends JsonResource
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
			'name'  =>  $this->name,
			'store_id'  =>  $this->store_id,
			'price'  =>  $this->price,
			'vat_included'  =>  $this->vat_included,
			'store'  =>  $this->when($this->relationLoaded('store'),function (){ return new StoreResource($this->store);}),
        ];
    }
}
