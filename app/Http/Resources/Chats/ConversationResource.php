<?php

namespace App\Http\Resources\Chats;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserResources;
use App\Http\Resources\Chats\MessageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'restaurant_id' => $this->restaurant_id,
            'status' => $this->status,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'receiver' => new UserResources($this->receiver),
            'sender' => new UserResources($this->sender),
            'messages' => MessageResource::collection($this->whenLoaded('messages'))
        ];
    }
}
