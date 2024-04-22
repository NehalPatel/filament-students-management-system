<?php

namespace App\Http\Resources\Student;

use App\Http\Resources\Division\DivisionResource;
use App\Http\Resources\Stream\StreamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
            'stream' => new StreamResource($this->stream),
            'division' => new DivisionResource($this->division),
        ];
    }
}
