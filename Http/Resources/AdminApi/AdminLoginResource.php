<?php

namespace App\Http\Resources\AdminApi;

use Illuminate\Http\Request;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class AdminLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'phone' => $this->phone,
        ];
    }
}
