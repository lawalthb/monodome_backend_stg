<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $this->load('admin', 'ticket', 'attachments');


        return [
            'id' => $this->id,
            'message' => $this->message,
            'admin' => new UserResource($this->admin),
         //   "ticket" => new SupportTicketResource($this->ticket),
            "attachments" => SupportAttachmentResource::collection($this->attachments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
