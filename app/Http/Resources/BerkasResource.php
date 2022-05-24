<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BerkasResource extends JsonResource
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
            'urutan' => $this->urutan,
            'id_ssw' => $this->id_ssw,
            'id_arsip' => $this->id_arsip,
            'is_bast_admin' => $this->is_bast_admin,
            'is_bast_fisik' => $this->is_bast_fisik,
            'status' => $this->status,
            'permohonan_persyaratan_file_count' => $this->when(isset($this->permohonan_persyaratan_file_count), $this->permohonan_persyaratan_file_count),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan_persyaratan_file' => PermohonanPersyaratanFileResource::collection($this->whenLoaded('permohonan_persyaratan_file'))
        ];

        return $result;
    }
}