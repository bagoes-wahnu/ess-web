<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KelurahanResource extends JsonResource
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
            'id_ssw' => $this->id_ssw,
            'id_ssw_provinsi' => $this->id_ssw_provinsi,
            'id_ssw_kabupaten' => $this->id_ssw_kabupaten,
            'id_ssw_kecamatan' => $this->id_ssw_kecamatan,
            'id_arsip' => $this->id_arsip,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'kecamatan' => new KecamatanResource($this->whenLoaded('kecamatan')),
            'user' => UserResource::collection($this->whenLoaded('user')),
            'permohonan' => PermohonanResource::collection($this->whenLoaded('permohonan'))
        ];

        return $result;
    }
}