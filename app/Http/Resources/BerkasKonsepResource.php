<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BerkasKonsepResource extends JsonResource
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
            'is_bast_admin' => $this->is_bast_admin,
            'is_bast_fisik' => $this->is_bast_fisik,
            'status' => $this->status,
            'permohonan_konsep_file_count' => $this->when(isset($this->permohonan_konsep_file_count), $this->permohonan_konsep_file_count),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan_konsep_file' => PermohonanKonsepFileResource::collection($this->whenLoaded('permohonan_konsep_file')),
            'permohonan_konsep_timeline' => PermohonanKonsepTimelineResource::collection($this->whenLoaded('permohonan_konsep_timeline')),
            'permohonan_koreksi_konsep_detail' => PermohonanKoreksiKonsepDetailResource::collection($this->whenLoaded('permohonan_koreksi_konsep_detail'))
        ];

        return $result;
    }
}