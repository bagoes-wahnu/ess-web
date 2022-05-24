<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanVerifikasiResource extends JsonResource
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
            'catatan' => $this->catatan,
            'status' => $this->status,
            'is_otomatis' => $this->is_otomatis,
            'jenis_bast' => $this->jenis_bast,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan')),
            'dinas' => new DinasResource($this->whenLoaded('dinas')),
            'permohonan_verifikasi_file' => PermohonanVerifikasiFileResource::collection($this->whenLoaded('permohonan_verifikasi_file'))
        ];

        return $result;
    }
}
