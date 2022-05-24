<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'nama' => $this->nama,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'role' => new RoleResource($this->whenLoaded('role')),
            'dinas' => new DinasResource($this->whenLoaded('dinas')),
            'kecamatan' => KecamatanResource::collection($this->whenLoaded('kecamatan')),
            'kelurahan' => KelurahanResource::collection($this->whenLoaded('kelurahan'))
        ];

        return $result;
    }
}
