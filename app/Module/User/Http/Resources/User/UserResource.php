<?php

namespace App\Module\User\Http\Resources\User;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class UserResource extends JsonResource
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
			'email'  =>  $this->email,
			'created_at'  =>  $this->created_at,
        ];
    }
}
