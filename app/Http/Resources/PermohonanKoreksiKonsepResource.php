<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanKoreksiKonsepResource extends JsonResource
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
            'status' => $this->status,
            'jenis_bast' => $this->jenis_bast,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan')),
            'dinas' => new DinasResource($this->whenLoaded('dinas')),
            'permohonan_koreksi_konsep_detail' => PermohonanKoreksiKonsepDetailResource::collection($this->whenLoaded('permohonan_koreksi_konsep_detail'))
        ];

        return $result;
    }
}
