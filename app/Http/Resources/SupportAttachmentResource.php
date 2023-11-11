<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportAttachmentResource extends JsonResource
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
            'support_message_id' => $this->support_message_id,
            'attachment' => getImageFile( $this->attachment),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
