<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelCompany\Mail\Http\Resources\Subscriber as SubscriberResource;

class Tag extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subscribers' => SubscriberResource::collection($this->whenLoaded('subscribers')),
            'created_at' => $this->created_at->toDateTimeString(),
            'update_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
