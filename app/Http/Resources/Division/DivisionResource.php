<?php

namespace App\Http\Resources\Division;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
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
            'stream_id' => $this->stream_id,
            'stream' => $this->stream->short_name,
            'name' => $this->name,
        ];
    }
}
