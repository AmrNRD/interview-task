<?php

namespace App\Module\Store\Http\Resources\Store;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use App\Module\User\Http\Resources\User\UserResource;;

class StoreResource extends JsonResource
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
			'user_id'  =>  $this->user_id,
			'shipping_cost'  =>  $this->shipping_cost,
			'vat'  =>  $this->vat,
			'vat_type'  =>  $this->vat_type,
			'user'  =>  $this->when($this->relationLoaded('user'),function (){ return new UserResource($this->user);}),
        ];
    }
}
