<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'ticket'=>$this->ticket,
            'user_id' => $this->user_id,
            'name'=>$this->name,
            'email'=>$this->email,
            'subject'=>$this->subject,
            'status'=>$this->status,
            'isClosed'=>$this->isClosed,
            'last_reply'=>$this->last_reply,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
