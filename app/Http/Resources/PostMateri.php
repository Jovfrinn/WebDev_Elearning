<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostMateri extends JsonResource
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
            'material_title' => $this->material_title,
            'material_image' => $this->material_image,
            'description' => $this->description,
            'id_teacher' => $this->id_teacher,
        ];
    }
}
