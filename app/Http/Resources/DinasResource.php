<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DinasResource extends JsonResource
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
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
            'id_ssw' => $this->id_ssw,
            'id_arsip' => $this->id_arsip,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'user' => UserResource::collection($this->whenLoaded('user')),
            'permohonan_verifikasi' => PermohonanVerifikasiResource::collection($this->whenLoaded('permohonan_verifikasi')),
            'permohonan_koreksi_konsep' => PermohonanKoreksiKonsepResource::collection($this->whenLoaded('permohonan_koreksi_konsep')),
            'permohonan_survey' => PermohonanSurveyResource::collection($this->whenLoaded('permohonan_survey')),
            'permohonan_evaluasi_survey' => PermohonanEvaluasiSurveyResource::collection($this->whenLoaded('permohonan_evaluasi_survey'))
        ];

        return $result;
    }
}
