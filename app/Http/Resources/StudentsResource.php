<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'mobile'          => $this->mobile,
            'spdid'           => $this->spdid,
            'enrollment_no'   => $this->enrollment_no,
            'address'         => $this->address,
            'city'            => $this->city,
            'gender'          => $this->gender,
            'profile_picture' => $this->profile_picture,
            // 'stream_id'     => $this->stream->id,
        ];
    }
}
