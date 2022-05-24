<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanKoreksiKonsepDetailResource extends JsonResource
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
            'is_revisi' => $this->is_revisi,
            'permohonan_koreksi_konsep_detail_file_count' => $this->when(isset($this->permohonan_koreksi_konsep_detail_file_count), $this->permohonan_koreksi_konsep_detail_file_count),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan_koreksi_konsep' => new PermohonanKoreksiKonsepResource($this->whenLoaded('permohonan_koreksi_konsep')),
            'berkas_konsep' => new BerkasKonsepResource($this->whenLoaded('berkas_konsep')),
            'permohonan_koreksi_konsep_detail_file' => PermohonanKoreksiKonsepDetailFileResource::collection($this->whenLoaded('permohonan_koreksi_konsep_detail_file'))
        ];

        return $result;
    }
}
