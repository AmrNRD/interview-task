<?php

namespace App\Module\Cart\Http\Resources\Cart;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use App\Module\User\Http\Resources\User\UserResource;;

class CartResource extends JsonResource
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
			'user_id'  =>  $this->user_id,
			'user'  =>  $this->when($this->relationLoaded('user'),function (){ return new UserResource($this->user);}),
        ];
    }
}
