<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanEvaluasiSurveyResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan')),
            'dinas' => new DinasResource($this->whenLoaded('dinas')),
            'permohonan_evaluasi_survey_file' => PermohonanEvaluasiSurveyFileResource::collection($this->whenLoaded('permohonan_evaluasi_survey_file'))
        ];

        return $result;
    }
}
