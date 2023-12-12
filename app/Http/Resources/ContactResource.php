<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chatKey' => $this->chat_key,
            'userId' => $this->user_id,
            'user' => !isset($this->user)? $this->user : $this->when($this->relationLoaded('user'), function () { return $this->user; }),
            'date' => $this->created_at,
        ];
    }
}
