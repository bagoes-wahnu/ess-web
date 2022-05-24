<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProsesPermohonanResource extends JsonResource
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
            'batas_waktu' => $this->batas_waktu,
            'jenis' => $this->jenis,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan_histori_penyelesaian' => PermohonanHistoriPenyelesaianResource::collection($this->whenLoaded('permohonan_histori_penyelesaian'))
        ];

        return $result;
    }
}
