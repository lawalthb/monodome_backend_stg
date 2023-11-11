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

        $this->load('supportMessage');


        return [
            "id"=> $this->id,
            'ticket'=>$this->ticket,
            'name'=>$this->name,
            'email'=>$this->email,
            'subject'=>$this->subject,
            'status'=>$this->status,
            'isClosed'=>$this->isClosed,
            'last_reply'=>$this->last_reply,
            'user' => new UserResource( $this->user),
            "supportMessage" => SupportMessageResource::collection($this->supportMessage),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
