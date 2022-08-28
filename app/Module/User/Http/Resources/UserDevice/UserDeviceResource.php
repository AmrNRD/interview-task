<?php

namespace App\Module\User\Http\Resources\UserDevice;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use App\Module\User\Http\Resources\User\UserResource;;

class UserDeviceResource extends JsonResource
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
			'fcm_token'  =>  $this->fcm_token,
			'type'  =>  $this->type,
			'user_id'  =>  $this->user_id,
			'user'  =>  $this->when($this->relationLoaded('user'),function (){ return new UserResource($this->user);}),
        ];
    }
}
